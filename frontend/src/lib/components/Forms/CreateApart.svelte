<script lang="ts">
  import { enhance } from "$app/forms";

  import { formHandler } from "$lib/functions";

  import Header from "./Components/Header.svelte";
  import Button from "../Button/Button.svelte";
  import { ImageInput, Input } from "../Input";
  import Textarea from "../Input/Textarea.svelte";
  import MultiImageInput from "../Input/MultiImageInput.svelte";
</script>

<form
  use:enhance={() =>
    async ({ result }) =>
      formHandler(result)}
  action="?/createHotel"
  enctype="multipart/form-data"
  method="post"
  class="w-full px-5 py-8 mx-auto my-auto bg-white rounded-md shadow-md xl:ml-20 dark:bg-darkmode-600 xl:bg-transparent sm:px-8 xl:p-0 xl:shadow-none sm:w-3/4 lg:w-2/4 xl:w-auto"
>
  <Header
    title="Araba Paylaşma"
    description="Araba oluşturabilmek için sadece birkaç adım kaldı. Tüm işlerinizi tek bir yerden yönetin"
  />
  <div class="mt-2">
    <MultiImageInput />
    <Input
      type="text"
      className="block px-4 py-3 mt-3 min-w-full xl:min-w-[350px]"
      placeholder="Araba Adı"
      name="name"
    />
    <Input
      type="text"
      className="block px-4 py-3 mt-3 min-w-full xl:min-w-[350px]"
      placeholder="Araba Modeli"
      name="model"
    />
    <Input
      type="text"
      className="block px-4 py-3 mt-3 min-w-full xl:min-w-[350px]"
      placeholder="Araba Markası"
      name="brand"
    />
    <Input
      type="text"
      className="block px-4 py-3 mt-3 min-w-full xl:min-w-[350px]"
      placeholder="Araba Kiralama fiyatı"
      name="price"
    />
    <Textarea
      placeholder="Araba Açıklaması"
      name="description"
      className="block px-4 py-3 mt-3 min-w-full xl:min-w-[350px]"
    />
  </div>
  <div class="mt-5 text-center xl:mt-8 xl:text-left">
    <Button
      type="submit"
      variant="primary"
      className="w-full px-4 py-3 align-top xl:w-32 xl:mr-3"
    >
      Başvur Yap
    </Button>
  </div>
</form>
