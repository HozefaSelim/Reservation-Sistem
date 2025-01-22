import { get, writable } from "svelte/store";

interface User {
  id: string;
  name: string;
  email: string;
  phone: string;
  role: string;
  image: string;
  token: string;
}

export const userStore = writable<User>();

export const user = () => {
  return get(userStore);
};

export const setUser = (user: User) => {
  userStore.update(() => {
    return user;
  });
};
