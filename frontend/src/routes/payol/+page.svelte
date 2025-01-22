<script>
  import { goto } from "$app/navigation";
  import Lucide from "@/lib/components/Lucide";
</script>

<div
  class="w-full h-screen bg-blue-800 flex items-center justify-center flex-col"
>
  <h3 class="mb-8 text-3xl font-bold text-white">Ne Olmak İstiyorusnuz?</h3>
  <div class="flex items-center justify-center flex-col md:flex-row gap-5">
    <button
      onclick={() => goto("/payol/otel_olustur")}
      class="bg-white rounded-3xl w-[320px] h-[200px] flex flex-col gap-5 items-center justify-center hover:scale-105 hover:bg-blue-100 transition-all"
      type="button"
    >
      <Lucide icon="KeySquare" className="w-20 h-20 text-blue-800" />
      <p class="text-2xl font-semibold">Otel sahibi ol</p>
    </button>
    <button
      onclick={() => goto("/payol/apartman_olustur")}
      class="bg-white rounded-3xl w-[320px] h-[200px] flex flex-col gap-5 items-center justify-center hover:scale-105 hover:bg-blue-100 transition-all"
      type="button"
    >
      <Lucide icon="Hotel" className="w-20 h-20 text-blue-800" />
      <p class="text-2xl font-semibold">Apartmanlar kiralamacı ol</p>
    </button>
    <button
      onclick={() => goto("/payol/araba_olustur")}
      class="bg-white rounded-3xl w-[320px] h-[200px] flex flex-col gap-5 items-center justify-center hover:scale-105 hover:bg-blue-100 transition-all"
      type="button"
    >
      <Lucide icon="Car" className="w-20 h-20 text-blue-800" />
      <p class="text-2xl font-semibold">Araba kiralamacı ol</p>
    </button>
  </div>
</div>
