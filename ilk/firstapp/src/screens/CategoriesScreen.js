import React, { useEffect, useState } from 'react';
import { View, Text, FlatList, ActivityIndicator, Image, StyleSheet } from 'react-native';
import { getCategories } from '../api/api';
import CategoryGrid from '../components/CategoryGrid';
import { useFocusEffect } from '@react-navigation/native';

const CategoryScreen = ({navigation}) => {
  const [loading, setLoading] = useState(true);
  const [categories, setCategories] = useState([]);

  const fetchCategories = async () => {
    try {
      const fetchedCategories = await getCategories();
      setCategories(fetchedCategories);
      setLoading(false);
    } catch (error) {
      Alert.alert(
        'Hata',
        'Kategoriler getirilirken bir sorun oluştu.',
        [{ text: 'Tamam' }])
      setLoading(false);
    }
  };
  useEffect(() => {
    fetchCategories();
  }, []);

  useFocusEffect(
    React.useCallback(() => {
      fetchCategories();
      return () => {
      };
    }, [])
  );

  function rederCategoryItem(category){
    function pressHandler(){
      navigation.navigate('Yemekler',{
        categoryId:category.item.id,
        categoryName:category.item.name
      })
    }
    return <CategoryGrid item={category.item} pressMeal={pressHandler}/>
  }

  if (loading) {
    return (
      <View style={{ flex: 1, justifyContent: 'center', alignItems: 'center' }}>
        <ActivityIndicator size="large" color="blue" />
      </View>
    );
  }

  return (
    <View style={{ flex: 1, paddingVertical: 30,paddingHorizontal:10}}>
      <FlatList
        data={categories}
        keyExtractor={(item) => item.id.toString()}
        numColumns={2} // Satırda 2 kart göstermek için
        renderItem={rederCategoryItem}
      />
    </View>
  );
};

const styles = StyleSheet.create({
});

export default CategoryScreen;
