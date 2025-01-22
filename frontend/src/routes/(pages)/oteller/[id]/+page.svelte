<script lang="ts">
  import { fade } from "svelte/transition";

  import Lucide from "$lib/components/Lucide";

  import { formatDate } from "$lib/functions";

  import Image1 from "$lib/assets/images/langing/1.jpg";
  import Image2 from "$lib/assets/images/langing/2.jpg";
  import Image3 from "$lib/assets/images/langing/3.jpg";
  import Image4 from "$lib/assets/images/langing/4.jpg";
  import Image5 from "$lib/assets/images/langing/5.jpg";

  export let data;

  const { reviews, id, name, description, location, rating, rooms } =
    data.hotel;

  const images = [Image1, Image2, Image3, Image4, Image5];
  let index = 0;
  let interval: NodeJS.Timeout;

  // Automatically update index at regular intervals
  function startSlideshow() {
    interval = setInterval(() => {
      index = (index + 1) % images.length; // Loop back to 0 after the last image
    }, 10000); // Change every 10 seconds
  }

  function stopSlideshow() {
    clearInterval(interval);
  }

  // Start the slideshow on component mount
  startSlideshow();

  // Clear the interval on component destroy
  import { onDestroy } from "svelte";
  import Button from "@/lib/components/Button";
  import { Input } from "@/lib/components/Input";
  import { goto } from "$app/navigation";
  onDestroy(() => {
    stopSlideshow();
  });
</script>

<div class="grid md:grid-cols-4 gap-5 px-5 md:px-10 lg:px-16 my-5">
  <div class="hidden md:block md:col-span-1">
    <ul class="h-fit w-full border rounded-3xl p-5 flex flex-col gap-2">
      <h3 class="text-3xl font-bold text-slate-800 my-5 border-b-2">
        Yorumlar
      </h3>
      {#each reviews as { id, user, rating, comment, created_at }}
        <li class="bg-blue-100/50 p-3 rounded-2xl">
          <div class="flex gap-2">
            <span
              class="p-2 bg-blue-800 rounded-lg text-white font-semibold text-lg"
              >{rating}</span
            >
            <div>
              <h5 class="text-blue-800 text-base font-medium">{user}</h5>
              <p class="text-slate-500 text-xs">
                {formatDate(created_at, "1")}
              </p>
            </div>
          </div>
          <p class="text-sm mt-3 font-medium text-slate-700">{comment}</p>
        </li>
      {/each}
      <a
        href={`/oteller/${id}#yorumlar`}
        class="underline text-end text-sm text-blue-800"
      >
        Tümü
      </a>
    </ul>
  </div>
  <div class="md:col-span-3 divide-y divide-blue-800">
    <div class="flex flex-col flex-1 gap-3">
      <div class="flex justify-between items-start">
        <div>
          <h4 class="text-blue-800 font-semibold text-3xl">{name}</h4>
          <p class="flex items-center gap-2 text-slate-600">
            <Lucide icon="MapPinCheckInside" />
            {location}
          </p>
        </div>
        <span
          class="p-2 bg-blue-800 rounded-lg text-white font-semibold text-xl"
          >{rating}</span
        >
      </div>
    </div>
    <div class="h-fit w-full border rounded-3xl p-5 mt-4 cursor-pointer">
      <div class="h-80 overflow-hidden rounded-2xl mb-3">
        {#each images as image, i (i)}
          {#if i === index}
            <img
              src={image}
              alt="otel"
              class="object-cover w-full h-full"
              transition:fade={{ duration: 400 }}
            />
          {/if}
        {/each}
      </div>
      <ul class="flex gap-2 flex-wrap mb-3">
        {#each images as image, i}
          <button
            onclick={() => (index = i)}
            class="h-20 w-20 overflow-hidden rounded-2xl"
          >
            <img src={image} alt="otel" class="object-cover w-full h-full" />
          </button>
        {/each}
      </ul>
      <p class="text-lg text-slate-700">
        {description}
      </p>
    </div>
    <form
      method="post"
      action="?/search"
      class="relative z-10 mt-5 flex items-center pt-4 flex-col gap-2 md:gap-0 md:flex-row"
    >
      <div class="relative flex-1 w-full">
        <Input
          placeholder="Giriş Tarihi - Çıkış Tarihi"
          className="font-medium pl-10 md:rounded-s-none md:rounded-e-none"
          type="text"
          name="date"
        />
        <Lucide
          icon="CalendarDays"
          className="absolute top-2 left-3 text-gray-500"
        />
      </div>
      <div class="relative flex-1 w-full">
        <Input
          placeholder="Kaç kişisiniz ?"
          className="font-medium pl-10 md:rounded-s-none md:rounded-e-none"
          type="text"
          name="Capasite"
        />
        <Lucide icon="User" className="absolute top-2 left-3 text-gray-500" />
      </div>
      <Button
        type="submit"
        variant="primary"
        className="md:rounded-s-none h-10 w-full md:w-32">Ara</Button
      >
    </form>
    <ul class="flex flex-col gap-5 mt-5 pt-4">
      {#each rooms as { id, name, capacity, discounted_price, description, rating, price }}
        <li
          class="h-fit w-full border rounded-3xl p-5 flex flex-col md:flex-row gap-5 cursor-pointer"
        >
          <div class="w-full md:w-52 h-52 overflow-hidden rounded-2xl">
            <img src={Image1} alt="otel" class="object-cover w-full h-full" />
          </div>
          <div class="flex flex-col flex-1 gap-3">
            <div class="flex justify-between items-start">
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
              <span
                class="w-10 h-10 flex items-center justify-center bg-blue-800 rounded-lg text-white font-semibold text-xl"
                >{rating}</span
              >
            </div>
            <p class="text-slate-700">
              {description}
            </p>
            <span class="p-2 flex gap-2 bg-blue-100 w-fit rounded-lg">
              <Lucide icon="Users" className="text-blue-800" />
              <p class="font-semibold">{capacity} kişilik</p>
            </span>
            <div class="flex-1 flex items-end justify-end">
              <Button
                onclick={() => goto(`/oteller/${id}/rezerv/${id}`)}
                variant="primary"
                type="button"
                className="w-fit">Rezerv Et</Button
              >
            </div>
          </div>
        </li>
      {/each}
    </ul>
    <ul
      id="#yorumlar"
      class="h-fit w-full border rounded-3xl p-5 mt-5 flex flex-col gap-2"
    >
      <h3 class="text-3xl font-bold text-slate-800 my-5 border-b-2">
        Yorumlar
      </h3>
      {#each reviews as { id, user, rating, comment, created_at }}
        <li class="bg-blue-100/50 p-3 rounded-2xl">
          <div class="flex gap-2">
            <span
              class="p-2 bg-blue-800 rounded-lg text-white font-semibold text-lg"
              >3.5</span
            >
            <div>
              <h5 class="text-blue-800 text-base font-medium">Hussein</h5>
              <p class="text-slate-500 text-xs">
                {formatDate(new Date(), "1")}
              </p>
            </div>
          </div>
          <p class="text-sm mt-3 font-medium text-slate-700">
            Çok kötü bir otel
          </p>
        </li>
      {/each}
    </ul>
  </div>
</div>
