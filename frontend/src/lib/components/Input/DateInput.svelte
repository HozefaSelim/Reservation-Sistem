<script lang="ts">
  import { twMerge } from "tailwind-merge";

  let { className = "", placeholder, name, ref = null, ...others } = $props();
</script>

<input
  {...others}
  type="date"
  {placeholder}
  {name}
  bind:this={ref}
  class={twMerge([
    "disabled:bg-gray-200 disabled:cursor-not-allowed disabled:border-gray-300 text-black",
    "[&[readonly]]:bg-gray-200 [&[readonly]]:cursor-not-allowed [&[readonly]]:border-gray-300",
    "transition duration-200 ease-in-out w-full text-sm border-gray-300 shadow-sm rounded-md placeholder:text-gray-500 focus:ring-4 focus:ring-blue-800 focus:ring-opacity-20 focus:border-blue-800 focus:border-opacity-40",
    ,
    className,
  ])}
/>
