import type { PageServerLoad } from "./$types";

export const load: PageServerLoad = async ({ cookies }) => {
  const user = JSON.parse(cookies.get("user") || "{}");

  return { user };
};
