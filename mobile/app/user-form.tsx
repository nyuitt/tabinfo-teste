import React, { useState, useEffect } from 'react';
import { View, Text, StyleSheet, ScrollView, Alert, Switch } from 'react-native';
import { useRouter, useLocalSearchParams } from 'expo-router';
import { Container } from '@/components/ui/container';
import { Input } from '@/components/ui/input';
import { Button } from '@/components/ui/button';
import { usersService } from '@/services/users';

export default function UserFormScreen() {
  const router = useRouter();
  const { userId } = useLocalSearchParams();
  const isEditing = !!userId;

  const [name, setName] = useState('');
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [isAdmin, setIsAdmin] = useState(false);
  const [loading, setLoading] = useState(false);

  useEffect(() => {
    if (isEditing) {
      loadUser();
    }
  }, [userId]);

  async function loadUser() {
    try {
      const user = await usersService.getById(Number(userId));
      setName(user.name);
      setEmail(user.email);
      setIsAdmin(user.is_admin);
    } catch (error) {
      Alert.alert('Erro', 'Não foi possível carregar os dados do usuário');
      router.back();
    }
  }

  async function handleSubmit() {
    if (!name || !email || (!isEditing && !password)) {
      Alert.alert('Erro', 'Preencha todos os campos obrigatórios');
      return;
    }

    setLoading(true);
    try {
      if (isEditing) {
        const data: any = { name, email, is_admin: isAdmin };
        if (password) {
          data.password = password;
        }
        await usersService.update(Number(userId), data);
        Alert.alert('Sucesso', 'Usuário atualizado com sucesso');
      } else {
        await usersService.create({
          name,
          email,
          password,
          is_admin: isAdmin,
        });
        Alert.alert('Sucesso', 'Usuário criado com sucesso');
      }
      router.back();
    } catch (error: any) {
      const message =
        error.response?.data?.message || 'Erro ao salvar usuário';
      Alert.alert('Erro', message);
    } finally {
      setLoading(false);
    }
  }

  return (
    <Container>
      <ScrollView contentContainerStyle={styles.scroll}>
        <View style={styles.content}>
          <View style={styles.card}>
            <Text style={styles.title}>
              {isEditing ? 'Editar Usuário' : 'Novo Usuário'}
            </Text>

            <Input
              label="Nome"
              placeholder="Nome completo"
              value={name}
              onChangeText={setName}
              autoCapitalize="words"
            />

            <Input
              label="E-mail"
              placeholder="email@exemplo.com"
              value={email}
              onChangeText={setEmail}
              keyboardType="email-address"
              autoCapitalize="none"
            />

            <Input
              label={isEditing ? 'Senha (deixe vazio para manter)' : 'Senha'}
              placeholder="Mínimo 8 caracteres"
              value={password}
              onChangeText={setPassword}
              secureTextEntry
            />

            <View style={styles.switchContainer}>
              <Text style={styles.switchLabel}>Administrador</Text>
              <Switch
                value={isAdmin}
                onValueChange={setIsAdmin}
                trackColor={{ false: '#e1e8ed', true: '#667eea' }}
                thumbColor="#fff"
              />
            </View>

            <Button
              title={isEditing ? 'Salvar Alterações' : 'Criar Usuário'}
              onPress={handleSubmit}
              loading={loading}
            />

            <Button
              title="Cancelar"
              variant="secondary"
              onPress={() => router.back()}
            />
          </View>
        </View>
      </ScrollView>
    </Container>
  );
}

const styles = StyleSheet.create({
  scroll: {
    flexGrow: 1,
  },
  content: {
    flex: 1,
    padding: 20,
  },
  card: {
    backgroundColor: '#fff',
    borderRadius: 12,
    padding: 24,
    shadowColor: '#000',
    shadowOffset: { width: 0, height: 2 },
    shadowOpacity: 0.1,
    shadowRadius: 8,
    elevation: 5,
  },
  title: {
    fontSize: 28,
    fontWeight: 'bold',
    color: '#333',
    marginBottom: 24,
  },
  switchContainer: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    alignItems: 'center',
    marginBottom: 24,
    paddingVertical: 8,
  },
  switchLabel: {
    fontSize: 16,
    fontWeight: '500',
    color: '#333',
  },
});
