<script lang="ts">
  import { goto } from "$app/navigation";
  import { enhance } from "$app/forms";

  import { formHandler } from "$lib/functions";

  import Header from "./Components/Header.svelte";
  import Button from "../Button/Button.svelte";
  import { Input, ImageInput } from "../Input";
</script>

<form
  action="?/createAccount"
  use:enhance={() =>
    async ({ result }) =>
      formHandler(result)}
  method="post"
  enctype="multipart/form-data"
  class="w-full px-5 py-8 mx-auto my-auto bg-white rounded-md shadow-md xl:ml-20 dark:bg-darkmode-600 xl:bg-transparent sm:px-8 xl:p-0 xl:shadow-none sm:w-3/4 lg:w-2/4 xl:w-auto"
>
  <Header
    title="Üye Ol"
    description="Hesabınızı oluşturabilmek için sadece birkaç adım kaldı. Tüm işlerinizi tek bir yerden yönetin"
  />
  <div class="mt-4">
    <ImageInput />
    <Input
      type="text"
      className="block px-4 py-3 mt-3 min-w-full xl:min-w-[350px]"
      placeholder="E-Posta"
      name="email"
    />
    <Input
      type="text"
      className="block px-4 py-3 mt-3 min-w-full xl:min-w-[350px]"
      placeholder="Adı Soyadı"
      name="name"
    />
    <Input
      type="text"
      className="block px-4 py-3 mt-3 min-w-full xl:min-w-[350px]"
      placeholder="Telefon Numarası (0 555 888 77 33)"
      name="phone"
    />
    <Input
      name="password"
      type="password"
      className="block px-4 py-3 mt-3 min-w-full xl:min-w-[350px]"
      placeholder="Şifre"
    />
    <Input
      name="confirmPassword"
      type="password"
      className="block px-4 py-3 mt-3 min-w-full xl:min-w-[350px]"
      placeholder="Şifreyi Tekrarla"
    />
  </div>
  <div class="mt-5 text-center xl:mt-8 xl:text-left">
    <Button
      type="submit"
      variant="primary"
      className="w-full px-4 py-3 align-top xl:w-36 xl:mr-3"
    >
      Hesap Oluştur
    </Button>
    <Button
      onclick={() => goto("/giris")}
      variant="outline-secondary"
      type="button"
      className="w-full px-4 py-3 mt-3 align-top xl:w-32 xl:mt-0"
    >
      Giriş Yap
    </Button>
  </div>
</form>
