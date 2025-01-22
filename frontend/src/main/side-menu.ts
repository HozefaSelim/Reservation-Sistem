import { Role, type Menu } from "@/stores/menu";

const menu: Array<Menu | "divider"> = [
  {
    icon: "MonitorCog",
    pathname: "/panel",
    title: "Panel",
  },
  "divider",
  {
    icon: "Hotel",
    title: "Odalar",
    // role: [Role.hotel_owner],
    subMenu: [
      {
        icon: "GalleryHorizontalEnd",
        pathname: "/panel/odalar",
        title: "Tüm Odalarım",
      },
      {
        icon: "ClipboardPlus",
        pathname: "/panel/odalar/olusturma",
        title: "Oda Ekle",
      },
    ],
  },
  {
    icon: "Car",
    title: "Arabalar",
    // role: [Role.hotel_owner],
    subMenu: [
      {
        icon: "SquareParking",
        pathname: "/panel/arabalar",
        title: "Tüm Arabalarım",
      },
      {
        icon: "SquarePlus",
        pathname: "/panel/arabalar/olusturma",
        title: "Araba Ekle",
      },
    ],
  },
  {
    icon: "House",
    title: "Apartmanlar",
    // role: [Role.hotel_owner],
    subMenu: [
      {
        icon: "Building2",
        pathname: "/panel/apartmanlar",
        title: "Tüm Apartmanlar",
      },
      {
        icon: "HousePlus",
        pathname: "/panel/apartmanlar/olusturma",
        title: "Apartman Ekle",
      },
    ],
  },
];

export default menu;
