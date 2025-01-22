import { icons } from "lucide-svelte";

interface navbar_items_type {
  icon: keyof typeof icons;
  path: string;
  value: string;
}

const navbar_items: navbar_items_type[] = [
  { icon: "Hotel", path: "/oteller", value: "Oteller" },
  { icon: "Car", path: "/arabalar", value: "Arabalar" },
  { icon: "House", path: "/apartmanlar", value: "Apartmanlar" },
];

export default navbar_items;
