import axios from "axios";

export const BASE_URL = 'base url girişi yapılır';


export const getCategories = async () => {
  try {
    const response = await axios.get(`${BASE_URL}api/categories`);
    return response.data;
   
  } catch (error) {
    console.error('Kategorileri getirirken hata oluştu:', error);
    throw error;
  }
};

// Yemekleri getiren API isteği
export const getMeals = async (id) => {
  try {
    const response = await axios.get(`${BASE_URL}api/meals/${id}`);
    return response.data;
  } catch (error) {
    console.error('Yemekleri getirirken hata oluştu:', error);
    throw error;
  }
};
export const getMeal = async (id) => {
  try {
    const response = await axios.get(`${BASE_URL}api/meal/${id}`);
    return response.data;
  } catch (error) {
    console.error('Yemek getirirken hata oluştu:', error);
    throw error;
  }
};

export const getCompanyInfo = async () => {
  try {
    const response = await axios.get(`${BASE_URL}api/company-info`);
    return response.data;
  } catch (error) {
    console.error('Şirket bilgilerini getirirken hata oluştu:', error);
    throw error;
  }
};
export const getCompanyImage = async () => {
    try {
      const response = await axios.get(`${BASE_URL}api/company-image`);
      return response.data;
    } catch (error) {
      console.error('Giriş yaparken hata oluştu:', error);
      throw error;
    }
  };

  export const login = async () => {
    try {
      const response = await axios.post(`${BASE_URL}api/auth/login`, { username, password });
      return response.data;
    } catch (error) {
      console.error('Şirket bilgilerini getirirken hata oluştu:', error);
      throw error;
    }
  };

  export const register = async () => {
    try {
      const response = await axios.post(`${BASE_URL}api/auth/register`, { name, user_name,email,password });
      return response.data;
    } catch (error) {
      console.error('Kayıt olurken hata oluştu:', error);
      throw error;
    }
  };


