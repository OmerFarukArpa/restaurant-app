import { StatusBar } from 'expo-status-bar';
import { StyleSheet, Text, View,Image ,ScrollView} from 'react-native';

export default function App() {
  return (
    <ScrollView style={styles.container} contentContainerStyle={styles.content}>
     
    <View style={styles.content}>
    <Image
          style={styles.searchIcon}
          source={require('./assets/arama.png')} // Arama simgesinin uygun bir resim dosyasının yolunu girin
        />
        {/* Arama çubuğu metni (opsiyonel) */}
        <Text style={styles.searchText}>Ara</Text>
      <Image
        style={styles.restaurantImage}
        source={require('./assets/resim.jpg')} // İlk restoran için uygun bir resim dosyasının yolunu girin
        
      />
      <Image
        style={styles.restaurantImage}
        source={require('./assets/resim2.jpg')} // İkinci restoran için uygun bir resim dosyasının yolunu girin
      />
      <Image
        style={styles.restaurantImage}
        source={require('./assets/resim3.jpg')} //  
      />
      <Image
        style={styles.restaurantImage}
        source={require('./assets/resim4.jpg')} //  
      />
       <Image
        style={styles.restaurantImage}
        source={require('./assets/resim5.jpg')} //  
      />
       
    </View>
    </ScrollView>
  );
}

const styles = StyleSheet.create({
  container: {
    flex: 1,
    
    backgroundColor:'#fff9c4',
  },
  logo: {
    width: 200,
    height: 200,
    marginBottom: 20,
  },
  content: {
    justifyContent: 'center',
    alignItems: 'center',
    paddingBottom: 20, // İçerik alt kısmında 20 birim boşluk bırakır
  },
  restaurantImage: {
    width: 150,
    height: 150,
    marginVertical: 10, // Yatay olarak sıralanmış resimler arasında dikey boşluk ekleyin
  },
  searchBar: {
    flexDirection: 'row',
    alignItems: 'center',
    backgroundColor: '#f0f0f0', // Arama çubuğunun arka plan rengi
    padding: 10,
    marginBottom: 10,
    borderRadius: 5,
  },
  searchIcon: {
    width: 150,
    height: 40,
    marginRight: 10,
  },
  searchText: {
    fontSize: 16,
    color: '#888', // Arama çubuğu metni rengi
  },
});
