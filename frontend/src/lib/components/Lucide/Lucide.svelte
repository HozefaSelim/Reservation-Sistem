<script lang="ts">
  import type { SVGAttributes } from "svelte/elements";
  import { icons } from "lucide-svelte";
  import { twMerge } from "tailwind-merge";

  interface LucideProps extends SVGAttributes<SVGSVGElement> {
    className?: string;
    icon: keyof typeof icons;
  }

  const { className = undefined, icon }: LucideProps = $props();
</script>

{#if icon in icons}
  {@const IconComponent = icons[icon]}
  <IconComponent class={twMerge(["stroke-1.5 w-5 h-5", className])} />
{:else}
  <p>Icon not found</p>
{/if}
