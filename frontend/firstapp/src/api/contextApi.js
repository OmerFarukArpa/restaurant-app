import React, { createContext, useState } from 'react';

const defaultValue = {
 id:'',
 user_name:'',
 name:'',
 email:''
};

const UserContext = createContext(defaultValue);

const UserProvider = ({ children }) => {
  const [user, setUser] = useState(defaultValue);

  const updateUser = (updatedUser) => {
    setUser((prevState) => ({ ...prevState, ...updatedUser }));
  };

  return (
    <UserContext.Provider value={{ user, updateUser }}>
      {children}
    </UserContext.Provider>
  );
};

export { UserContext, UserProvider };