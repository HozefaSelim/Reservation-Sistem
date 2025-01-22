import { writable } from "svelte/store";

import sideMenu from "@/main/side-menu";

import { icons } from "lucide-svelte";

export enum Role {
  Admin,
  hotel_owner,
  apartment_owner,
  car_owner,
  normal_user,
}

export interface Menu {
  icon: keyof typeof icons;
  title: string;
  role?: Role[];
  badge?: number;
  pathname?: string;
  subMenu?: Menu[];
  ignore?: boolean;
}

export interface MenuState {
  menu: Array<Menu | "divider">;
}

export const menuStore = writable<MenuState>({
  menu: [],
});

export const menu = () => {
  return sideMenu;
};
