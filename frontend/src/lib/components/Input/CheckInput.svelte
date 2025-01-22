<script lang="ts">
  import { twMerge } from "tailwind-merge";

  let {
    checked = false,
    disabled = false,
    className = "",
    name,
    ...others
  } = $props();

  function toggleSwitch() {
    if (!disabled) checked = !checked;
  }
</script>

<div
  role="switch"
  aria-checked={checked}
  aria-disabled={disabled}
  tabindex="0"
  onclick={toggleSwitch}
  onkeydown={(e) => e.key === "Enter" && toggleSwitch()}
  class={twMerge([
    "relative inline-flex items-center h-6 w-11 cursor-pointer",
    "transition-colors duration-200 ease-in-out",
    "focus:outline-none focus:ring-4 focus:ring-blue-800 focus:ring-opacity-20",
    "rounded-full",
    checked ? "bg-blue-600" : "bg-gray-200",
    disabled ? "opacity-50 cursor-not-allowed" : "",
    className,
  ])}
  {...others}
>
  <span
    class={twMerge([
      "inline-block h-4 w-4 transform bg-white rounded-full",
      "transition-transform duration-200 ease-in-out",
      checked ? "translate-x-5" : "translate-x-1",
    ])}
  />
</div>
