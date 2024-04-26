import React from 'react';
import { NavigationContainer } from '@react-navigation/native';
import { createNativeStackNavigator } from '@react-navigation/native-stack';
import { createDrawerNavigator } from '@react-navigation/drawer';

import CategoriesScreen from './src/screens/CategoriesScreen';
import MealsScreen from './src/screens/MealsScreen';
import MealDetailScreen from './src/screens/MealDetailScreen';
import LoginScreen from './src/screens/LoginScreen';
import MessageScreen from './src/screens/MessageScreen';
import ReservationScreen from './src/screens/ReservationScreen';
import ReservationListScreen from './src/screens/ReservationListScreen';
import RegisterScreen from './src/screens/RegisterScreen';
import { UserProvider } from './src/api/contextApi';
import CompanyInfoScreen from './src/screens/CompanyInfoScreen';

const Stack = createNativeStackNavigator();
const Drawer = createDrawerNavigator();

function DrawerNavigator() {
  return (
    <Drawer.Navigator
      screenOptions={{
        headerStyle: { backgroundColor: '#9e2a2b' },
        headerTintColor: '#fff',
        contentStyle: { backgroundColor: '#edf2fb' }
      }}>
      <Drawer.Screen name="Kategoriler" component={CategoriesScreen} />
      <Drawer.Screen name="Mesaj Gönder" component={MessageScreen} />
      <Drawer.Screen name="Rezervasyon Oluştur" component={ReservationScreen} />
      <Drawer.Screen name="Rezervasyonlarım" component={ReservationListScreen} />
      <Drawer.Screen name="Şirket Bilgisi" component={CompanyInfoScreen} />
      <Drawer.Screen
        name="Çıkış Yap"
        component={Logout} // Çıkış yap seçeneğine tıklandığında Logout componenti aktif olacak
        options={{ headerShown: false, drawerLabel: 'Çıkış Yap' }} // Header gözükmez, sadece "Çıkış Yap" yazsın
      />
    </Drawer.Navigator>
  );
}

// Çıkış yap seçeneğine tıklandığında Stack Navigator'ın en üstündeki ekranın aktif olmasını sağlayan Logout componenti
const Logout = ({ navigation }) => {
  React.useEffect(() => {
    const unsubscribe = navigation.addListener('focus', () => {
      // Çıkış yapıldığında Drawer Navigator'a geri dönüş yaparak Kategoriler ekranına yönlendirilir.
      navigation.navigate('Kategoriler');
      // Stack Navigator'daki tüm ekranlar pop edilir, yani ana ekrana dönülür.
      navigation.popToTop();
    });

    return unsubscribe;
  }, [navigation]);

  return null;
};

export default function App() {
  return (
    <UserProvider>
      <NavigationContainer>
        <Stack.Navigator
          screenOptions={{
            headerStyle: { backgroundColor: '#9e2a2b' },
            headerTintColor: '#fff',
            contentStyle: { backgroundColor: '#edf2fb' }
          }}>
          <Stack.Screen
            name="Login"
            component={LoginScreen}
            options={{ headerTitle: 'Giriş' }}
          />
          <Stack.Screen
            name="Drawer"
            component={DrawerNavigator}
            options={{ headerShown: false }}
          />
          <Stack.Screen name="Register" options={{ headerTitle: 'Kayıt Ol' }} component={RegisterScreen} />
          <Stack.Screen name="Yemekler" component={MealsScreen} />
          <Stack.Screen name="Yemek Detay" component={MealDetailScreen} />
        </Stack.Navigator>
      </NavigationContainer>
    </UserProvider>
  );
}
