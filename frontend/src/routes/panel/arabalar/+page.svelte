<script lang="ts">
  import { debounce, formHandler, submitForm, truncate } from "$lib/functions";

  import { goto } from "$app/navigation";
  import { enhance } from "$app/forms";
  import { fly } from "svelte/transition";

  import Button from "$lib/components/Button";

  import Lucide from "$lib/components/Lucide";
  import * as Dialog from "$lib/components/Dialog";
  import { Input, CheckInput } from "@/lib/components/Input";

  import Image from "$lib/assets/images/langing/2.jpg";

  export let data;

  // let packages = data.packages;
  // let packageId: string;

  // function filterPackages() {
  //   packages = packages.filter((category) => category.id !== packageId);
  // }

  // function setPackages(data: any) {
  //   packages = data;
  // }

  let deleteConfirmationModal = false;
  let filterForm: HTMLFormElement;
</script>

<h2 class="mt-10 text-lg font-medium">Odalar Listesi</h2>
<div class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-5">
  <div
    class="flex flex-col md:flex-row sm:col-span-2 md:col-span-3 lg:col-span-4 justify-between gap-3"
  >
    <Button
      variant="primary"
      type="button"
      onclick={() => goto("/panel/odalar/olusturma")}
      className="shadow-md">Yeni Ekle</Button
    >
    <div class="w-full md:w-56">
      <form
        use:enhance={() =>
          async ({ result }) => {
            if (result.type === "failure") {
              return formHandler(result);
            }
            if (result.type === "success") {
              // setPackages(result.data);
            }
          }}
        bind:this={filterForm}
        action="?/filter"
        method="post"
      >
        <Input
          name="name"
          oninput={debounce(() => submitForm(filterForm))}
          class="pr-10"
          placeholder="Arama..."
        />
      </form>
    </div>
  </div>
  <!-- BEGIN: Users Layout -->
  <!-- {#each packages as { active, id, photo_url, name, _count }} -->
  <div transition:fly={{ x: 200 }} class="box intro-y">
    <div class="p-5">
      <div
        class="h-40 overflow-hidden rounded-md 2xl:h-56 image-fit before:block before:absolute before:w-full before:h-full before:top-0 before:left-0 before:z-10 before:bg-gradient-to-t before:from-black before:to-black/10"
      >
        <img alt="" class="rounded-md" src={Image} />
        <form
          use:enhance={() =>
            async ({ result }) => {
              formHandler(result);
              // active = !active;
            }}
          method="post"
          action="?/updateCategoryStatus"
          class="block text-base font-medium absolute top-0 z-10 px-2 pt-2 text-white"
          id={`form-${"hjkashd"}`}
        >
          <input type="text" name="id" value={"djsadj"} hidden />
          <CheckInput checked={false} name="available" />
        </form>
        <a
          href={`/panel/urunler/${"djasd"}`}
          class="block absolute bottom-0 z-10 px-5 pb-6 text-white"
        >
          <h3 class="text-base font-medium">Collesium Garden</h3>
          <p class="text-sm font-light">
            {truncate(
              "Merkeze yakın, doğayla iç içe Collesium Garden, sizi huzurlu bir masalın içinde kaybolmaya davet ediyor.",
              25
            )}
          </p>
        </a>
      </div>
      <div class="mt-5 text-slate-600 dark:text-slate-500">
        <div class="flex items-center mt-2">
          <Lucide icon="SquareCheck" className="w-4 h-4 mr-2" />
          Durum:
          <p class={`ml-1 ${true ? "text-success" : "text-danger"}`}>
            {true ? "Aktif" : "Pasif"}
          </p>
        </div>
        <div class="flex items-center mt-2">
          <Lucide icon="Users" className="w-4 h-4 mr-2" />
          Model: {"dkajsd"}
        </div>
        <div class="flex items-center mt-2">
          <Lucide icon="Users" className="w-4 h-4 mr-2" />
          Marka: {"dkajsd"}
        </div>
        <div class="flex items-center mt-2">
          <Lucide icon="Users" className="w-4 h-4 mr-2" />
          Plaka: {"dkajsd"}
        </div>
        <div class="flex items-center mt-2">
          <Lucide icon="CircleDollarSign" className="w-4 h-4 mr-2" /> Net Tutarı:
          {#if 323 > 0}
            <p class="line-through mx-1">{400}</p>
          {/if}
          <p class="mx-1 font-bold">
            {323}₺
          </p>
        </div>
        <div class="flex items-center mt-2">
          <Lucide icon="Container" className="w-4 h-4 mr-2" /> Sayısı: {"32"}
        </div>
      </div>
    </div>
    <div
      class="flex items-center justify-center p-5 border-t lg:justify-end border-slate-200/60 dark:border-darkmode-400"
    >
      <!-- <a
        class="flex items-center mr-auto text-primary"
        href={`/panel/urunler?kategory=${name}`}
      >
        <Lucide icon="Eye" class="w-4 h-4 mr-1" /> Göster
      </a> -->
      <a class="flex items-center mr-3" href={`/panel/odalar/duzelt/hdskfh`}>
        <Lucide icon="SquareCheck" class="w-4 h-4 mr-1" /> Düzelt
      </a>
      <a
        class="flex items-center text-danger"
        href="#top"
        on:click={(event) => {
          event.preventDefault();
          // packageId = id;
          deleteConfirmationModal = true;
        }}
      >
        <Lucide icon="Trash2" class="w-4 h-4 mr-1" /> Sil
      </a>
    </div>
  </div>
  <!-- {/each} -->
</div>
<Dialog.Root bind:open={deleteConfirmationModal}>
  <Dialog.Content class="sm:max-w-[425px]">
    <div class="p-5 text-center">
      <div class="mt-5 text-3xl">Emin misin?</div>
      <div class="mt-2 text-slate-500">
        Bu oda gerçekten silmek istiyor musunuz? <br />
        Bu işlem geri alınamaz.
      </div>
    </div>
    <form
      use:enhance={() =>
        async ({ result }) => {
          formHandler(result);

          // if (result.type === "success") filterPackages();

          deleteConfirmationModal = false;
        }}
      method="post"
      action="?/deleteCategory"
      class="px-5 pb-8 text-center"
    >
      <input type="text" name="id" value={"dasd"} hidden />
      <Button
        variant="outline-secondary"
        type="button"
        onclick={() => {
          deleteConfirmationModal = false;
        }}
        class="w-24 mr-1"
      >
        Vazgeç
      </Button>
      <Button variant="danger" type="submit" class="w-24">Sil</Button>
    </form>
  </Dialog.Content>
</Dialog.Root>
