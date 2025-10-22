import React from 'react';
import { View, StyleSheet, ViewProps } from 'react-native';
import { SafeAreaView } from 'react-native-safe-area-context';

interface ContainerProps extends ViewProps {
  safe?: boolean;
}

export function Container({ children, safe = true, style, ...props }: ContainerProps) {
  const Wrapper = safe ? SafeAreaView : View;

  return (
    <Wrapper style={[styles.container, style]} {...props}>
      {children}
    </Wrapper>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    backgroundColor: '#f5f5f5',
  },
});
