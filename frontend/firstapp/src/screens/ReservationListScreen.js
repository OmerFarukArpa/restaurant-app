import React, { useEffect, useState,useContext } from 'react';
import { View, FlatList, Text, StyleSheet } from 'react-native';
import { useFocusEffect } from '@react-navigation/native'; // useFocusEffect ekranın her odaklandığında çalışacak bir hook sağlar
import { BASE_URL } from '../api/api';
import axios from 'axios';
import { UserContext } from '../api/contextApi';
import Icon from 'react-native-vector-icons/Feather';


const ReservationListScreen = () => {
    const [data, setData] = useState(null);
    const { user } = useContext(UserContext);

    const fetchData = async () => {
      try {
        const response = await axios.get(`${BASE_URL}api/reservations/${user.id}`);
        setData(response.data);
      } catch (error) {
        Alert.alert('Hata', 'Veriler çekilirken bir sorun oluştu.',[{ text: 'Tamam' }]);
      }
    };

    // Bu useEffect sadece bileşen yüklendiğinde çalışacak
    useEffect(() => {
      fetchData(); 
    }, []);

    // useFocusEffect kullanarak, her sayfa odaklandığında (drawer'dan sayfaya geçişte) verilerin tekrar çekilmesini sağlayabilirsiniz
    useFocusEffect(
      React.useCallback(() => {
        fetchData();
        return () => {
          // İstenirse ekran odaklanmadığında yapılması gereken temizleme işlemleri buraya yazılabilir
        };
      }, [])
    );

  const renderItem = ({ item }) => (
    <View style={styles.row}>
      <Text style={styles.cell}>{item.date}</Text>
      <Text style={styles.cell}>
        {item.reservation_status_id == 1 ? 
            <Icon name="clock" size={30} color="orange" /> : 
            item.reservation_status_id == 2 ? 
            <Icon name="check-circle" size={30} color="green" /> : 
            item.reservation_status_id == 3 ? 
            <Icon name="x-circle" size={30} color="red" /> : ''}
    </Text>
    </View>
  );

  return (
    <View style={styles.container}>
        <View style={{flexDirection:'row',alignItems:'center',justifyContent:'space-between',marginBottom:30}}>
            <View style={{flexDirection:'row',alignItems:'center',gap:4}}>
                <Icon name="clock" size={30} color="orange" />
                <Text>: Beklemede</Text>
            </View>
            <View style={{flexDirection:'row',alignItems:'center',gap:4}}>
                <Icon name="check-circle" size={30} color="green" />
                <Text>: Onaylandı</Text>
            </View>
            <View style={{flexDirection:'row',alignItems:'center',gap:4}}>
                <Icon name="x-circle" size={30} color="red" />
                <Text>: İptal edildi</Text>
            </View>
        </View>
      <View style={styles.header}>
        <Text style={styles.headerText}>Rezervasyon Tarihi</Text>
        <Text style={styles.headerText}>Durum</Text>
      </View>
      <FlatList
        data={data}
        renderItem={renderItem}
        keyExtractor={item => item.id.toString()}
      />
    </View>
  );
};

const styles = StyleSheet.create({
  container: {
    flex: 1,
    paddingHorizontal:30,
    marginTop:60
  },
  header: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    
    borderTopWidth: 1,
    borderBottomWidth: 1,
    borderBottomColor: 'black',
    paddingVertical:10
  },
  headerText: {
    fontWeight: 'bold',
    fontSize:16,
    flex: 1,
    textAlign: 'center',
    letterSpacing:1
  },
  row: {
    flexDirection: 'row',
    justifyContent: 'space-between',
    marginBottom: 5,
    borderBottomWidth: 1,
    borderBottomColor: 'black',
    paddingVertical:10,
    alignItems:'center'
  },
  cell: {
    flex: 1,
    textAlign: 'center',
  },
});

export default ReservationListScreen;
