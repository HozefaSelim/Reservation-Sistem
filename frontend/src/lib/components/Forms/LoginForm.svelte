<script lang="ts">
  import { goto } from "$app/navigation";
  import { enhance } from "$app/forms";

  import { formHandler } from "$lib/functions";

  import Header from "./Components/Header.svelte";
  import Button from "../Button/Button.svelte";
  import { Input } from "../Input";
</script>

<form
  use:enhance={() =>
    async ({ result }) =>
      formHandler(result)}
  method="post"
  class="w-full px-5 py-8 mx-auto my-auto bg-white rounded-md shadow-md xl:ml-20 dark:bg-darkmode-600 xl:bg-transparent sm:px-8 xl:p-0 xl:shadow-none sm:w-3/4 lg:w-2/4 xl:w-auto"
>
  <Header
    title="Giriş yap"
    description="Hesabınıza giriş yapmak için sadece birkaç adım kaldı. Tüm işlerinizi tek bir yerden yönetin"
  />
  <div class="mt-8">
    <Input
      type="text"
      className="block px-4 py-3 min-w-full xl:min-w-[350px]"
      placeholder="E-Posta"
      name="email"
    />
    <Input
      name="password"
      type="password"
      className="block px-4 py-3 mt-4 min-w-full xl:min-w-[350px]"
      placeholder="Şifre"
    />
  </div>
  <div class="flex mt-4 text-xs text-slate-600 dark:text-slate-500 sm:text-sm">
    <a href="/sifremiunuttum">Şifremi Unuttum</a>
  </div>
  <div class="mt-5 text-center xl:mt-8 xl:text-left">
    <Button
      type="submit"
      variant="primary"
      className="w-full px-4 py-3 align-top xl:w-32 xl:mr-3"
    >
      Giriş Yap
    </Button>
    <Button
      onclick={() => goto("/uyeol")}
      variant="outline-secondary"
      type="button"
      className="w-full px-4 py-3 mt-3 align-top xl:w-32 xl:mt-0"
    >
      Üye Ol
    </Button>
  </div>
</form>
