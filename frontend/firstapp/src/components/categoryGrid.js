import { StyleSheet, Text, View,Image, Pressable } from 'react-native'
import React from 'react'
import { BASE_URL } from '../api/api';

export default function CategoryGrid({item,pressMeal}) {

    return (
        <Pressable
        style={styles.card}
        onPress={pressMeal}
        >
            
            <Image
            style={styles.image}
            source={{ uri: BASE_URL + item.image }} // item.image burada kategorinin resminin URL'sini içerir
            />
            <Text style={styles.categoryName}>{item.name}</Text>
        
        </Pressable>
         
      );
    };
    
    const styles = StyleSheet.create({
      card: {
        width: '45%', // Kartın genişliği
        margin: '2.5%', // Kartlar arasındaki boşluk
        backgroundColor: '#fff',
        borderRadius: 10,
        shadowColor: '#000',
        shadowOpacity: 0.25,
        shadowOffset: { width: 0, height: 2 },
        shadowRadius: 5,
        position:'relative',
        elevation: 5,
        justifyContent:'center',
        alignItems: 'center', // Kart içeriğini yatayda hizala
      },
      image: {
        width: '100%',
        height: 150,
        borderTopLeftRadius: 10,
        borderTopRightRadius: 10,
        resizeMode: 'cover', // Resmin boyutlandırılma türü
      },
      categoryName: {
        padding:5,
        fontSize:18
      },
    });