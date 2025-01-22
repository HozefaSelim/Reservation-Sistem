<script lang="ts">
  import Image from "$lib/assets/images/langing/5.jpg";

  import Icon from "@iconify/svelte";

  import Button from "$lib/components/Button";
  import Lucide from "$lib/components/Lucide";
  import { Input } from "$lib/components/Input";
  import SelectInput from "@/lib/components/Input/SelectInput.svelte";
  import { goto } from "$app/navigation";
  import { enhance } from "$app/forms";
  import turkishCities from "@/lib/constants/cities.js";
  import { debounce, submitForm } from "@/lib/functions/general.js";

  export let data;

  let cars = data.cars;
  const options = data.options;

  let rate = 0; // Example rate (can be any value between 0 and 5)
  let maxStars = 5; // Total number of stars

  let form: HTMLFormElement;
  let form2: HTMLFormElement;

  function setCars(data: any) {
    cars = data;
  }
</script>

<div
  style={`background-image:url(${Image});`}
  class="w-full h-[34.8rem] bg-cover bg-no-repeat bg-center relative flex justify-center flex-col gap-3 px-5 md:px-10 lg:px-16 text-white"
>
  <h2 class="relative z-10 text-2xl md:text-5xl font-bold">
    Arablar Fırsatları Kaçırmayın <br /> Son Gün 3 Ocak
  </h2>
  <p class="relative z-10 text-xl md:text-2xl">
    %50'ye varan indirimlere ilave <span
      class="font-bold bg-blue-800 py-1 px-4 rounded-3xl">cashback</span
    > Hediye!
  </p>
  <form
    use:enhance={() =>
      async ({ result }) => {
        if (result.type === "success") {
          setCars(result.data);
          goto("#list");
        }
      }}
    bind:this={form2}
    method="post"
    action="?/filter"
    class="relative z-10 mt-5 flex items-center flex-col gap-2 md:gap-0 md:flex-row"
  >
    <div class="relative flex-1 w-full">
      <Input
        placeholder="Nereye Gidiyorsun"
        className="font-medium pl-10 md:rounded-e-none"
        type="text"
        name="location"
      />
      <Lucide icon="Locate" className="absolute top-2 left-3 text-gray-500" />
    </div>
    <div class="relative flex-1 w-full">
      <Input
        placeholder="Min Bütçeniz"
        className="font-medium pl-10 md:rounded-s-none md:rounded-e-none"
        type="text"
        name="price_min"
      />
      <Lucide
        icon="DollarSign"
        className="absolute top-2 left-3 text-gray-500"
      />
    </div>
    <div class="relative flex-1 w-full">
      <Input
        placeholder="Araba Adı"
        className="font-medium pl-10 md:rounded-s-none md:rounded-e-none"
        type="text"
        name="name"
      />
      <Lucide icon="Car" className="absolute top-2 left-3 text-gray-500" />
    </div>
    <Button
      type="submit"
      variant="primary"
      className="md:rounded-s-none h-10 w-full md:w-32">Ara</Button
    >
  </form>
  <!-- svelte-ignore element_invalid_self_closing_tag -->
  <div
    class="bg-gradient-to-t from-blue-800/40 absolute top-0 left-0 w-full h-full"
  />
</div>
<div class="grid md:grid-cols-4 gap-5 px-5 md:px-10 lg:px-16 my-5">
  <div class="md:col-span-1">
    <h3 class="text-3xl font-bold text-slate-800 my-5">Filtrele</h3>
    <form
      action="?/filter"
      use:enhance={() =>
        async ({ result }) => {
          if (result.type === "success") setCars(result.data);
        }}
      bind:this={form}
      method="post"
      class="h-fit w-full border rounded-3xl p-5 flex flex-col gap-5"
    >
      <Input placeholder="Ara" name="name" />
      <div class="flex flex-col gap-3">
        <h4 class="font-medium text-lg">Şehiri Seç</h4>
        <SelectInput
          name="location"
          options={turkishCities}
          placeholder="Şehiri Seç"
          oninput={debounce(() => submitForm(form))}
        />
      </div>
      <div class="flex flex-col gap-3">
        <h4 class="font-medium text-lg">Modeli Seç</h4>
        <SelectInput
          name="model"
          options={options.models}
          placeholder="Modeli Seç"
          type={2}
          onchange={debounce(() => submitForm(form))}
        />
      </div>
      <div class="flex flex-col gap-3">
        <h4 class="font-medium text-lg">Markası Seç</h4>
        <SelectInput
          name="brand"
          options={options.brands}
          placeholder="Markası Seç"
          type={2}
          onchange={debounce(() => submitForm(form))}
        />
      </div>
      <div>
        <h4 class="font-medium text-lg">Rati Seç</h4>
        <input type="text" name="rating" hidden bind:value={rate} />
        <div class="flex justify-evenly mt-2 cursor-pointer">
          {#each Array(maxStars) as _, index}
            <button
              type="button"
              onclick={() => {
                rate = index + 1;
                submitForm(form);
              }}
              aria-label={`Rate ${index + 1} star${index + 1 > 1 ? "s" : ""}`}
            >
              <Icon
                icon="material-symbols:star-rounded"
                class={`star ${index < rate ? "text-yellow-500" : "text-slate-500"}`}
                width="45"
                height="45"
              />
            </button>
          {/each}
        </div>
      </div>
      <div>
        <h4 class="font-medium text-lg">Bütçeniz belirleyiniz</h4>
        <div class="flex justify-evenly gap-1 items-center mt-2">
          <Input
            oninput={debounce(() => submitForm(form))}
            placeholder="Min değer"
            name="price_min"
          />
          <p class="text-lg">-</p>
          <Input
            oninput={debounce(() => submitForm(form))}
            placeholder="Max değer"
            name="price_max"
          />
        </div>
      </div>
    </form>
  </div>
  <div class="md:col-span-3">
    <h3 class="text-3xl font-bold text-slate-800 my-5">Arablar</h3>
    <ul id="list" class="flex flex-col gap-5">
      {#each cars as { price, name, rating, description, brand, model, id, license_plate, discounted_price }}
        <li
          class="h-fit w-full border rounded-3xl p-5 flex flex-col md:flex-row gap-5 cursor-pointer"
        >
          <div class="w-full md:w-52 h-52 overflow-hidden rounded-2xl">
            <img src={Image} alt="otel" class="object-cover w-full h-full" />
          </div>
          <div class="flex flex-col flex-1 gap-3">
            <div class="flex justify-between items-start">
              <div>
                <h4 class="text-blue-800 font-semibold text-3xl lg:flex gap-2">
                  {name}
                  <span class="flex gap-2 text-orange-400 text-lg">
                    {#if discounted_price && discounted_price > 0}
                      <p class="text-gray-600 line-through">{price}</p>
                      ({discounted_price})
                    {:else}
                      ({price})
                    {/if}
                  </span>
                </h4>
              </div>
              <span
                class="w-10 h-10 flex items-center justify-center bg-blue-800 rounded-lg text-white font-semibold text-xl"
                >{rating}</span
              >
            </div>
            <p class="text-slate-700">
              {description}
            </p>
            <div class="flex flex-wrap w-full gap-2">
              <span class="p-2 flex gap-2 bg-blue-100 w-fit rounded-lg">
                <Lucide icon="Car" className="text-blue-800" />
                <p class="font-semibold">Model: {model}</p>
              </span>
              <span class="p-2 flex gap-2 bg-blue-100 w-fit rounded-lg">
                <Lucide icon="CalendarHeart" className="text-blue-800" />
                <p class="font-semibold">Marka: {brand}</p>
              </span>
              <span class="p-2 flex gap-2 bg-blue-100 w-fit rounded-lg">
                <Lucide icon="Hash" className="text-blue-800" />
                <p class="font-semibold">{license_plate}</p>
              </span>
            </div>
            <div class="flex-1 flex items-end justify-end">
              <Button
                onclick={() => goto(`/arabalar/${id}`)}
                variant="primary"
                type="button"
                className="w-fit">Detaylara Git</Button
              >
            </div>
          </div>
        </li>
      {/each}
    </ul>
  </div>
</div>
