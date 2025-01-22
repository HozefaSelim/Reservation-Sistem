<script lang="ts">
  import { twMerge } from "tailwind-merge";

  const { className = "", placeholder, name, ...others } = $props();
</script>

<!-- svelte-ignore element_invalid_self_closing_tag -->
<textarea
  {...others}
  {placeholder}
  {name}
  class={twMerge([
    "disabled:bg-gray-200 disabled:cursor-not-allowed disabled:border-gray-300",
    "[&[readonly]]:bg-gray-200 [&[readonly]]:cursor-not-allowed [&[readonly]]:border-gray-300",
    "transition duration-200 ease-in-out w-full text-sm border-gray-300 shadow-sm rounded-md placeholder:text-gray-500 focus:ring-4 focus:ring-blue-800 focus:ring-opacity-20 focus:border-blue-800 focus:border-opacity-40",
    className,
  ])}
/>
