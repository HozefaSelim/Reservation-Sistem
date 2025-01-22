<script lang="ts">
  import { twMerge } from "tailwind-merge";

  const { className = "", variant, type, children, ...others } = $props();

  // General Styles
  const generalStyles = [
    "transition duration-200 border shadow-sm inline-flex items-center justify-center py-2 px-3 rounded-md font-medium cursor-pointer", // Default
    "focus:ring-4 focus:ring-blue-800 focus:ring-opacity-20", // On focus
    "focus-visible:outline-none", // On focus visible
    "[&:hover:not(:disabled)]:bg-opacity-90 [&:hover:not(:disabled)]:border-opacity-90", // On hover and not disabled
    "[&:not(button)]:text-center", // Not a button element
    "disabled:opacity-70 disabled:cursor-not-allowed", // Disabled
  ];

  // Main Colors
  const primary = [
    "bg-blue-800 border-blue-800 text-white", // Default
  ];
  const secondary = [
    "bg-gray-700 border-gray-700 text-white", // Default
    "[&:hover:not(:disabled)]:bg-gray-600 [&:hover:not(:disabled)]:border-gray-600", // On hover and not disabled
  ];
  const success = [
    "bg-green-600 border-green-600 text-white", // Default
  ];
  const warning = [
    "bg-yellow-500 border-yellow-500 text-white", // Default
  ];
  const pending = [
    "bg-orange-500 border-orange-500 text-white", // Default
  ];
  const danger = [
    "bg-red-600 border-red-600 text-white", // Default
  ];
  const dark = [
    "bg-black border-black text-white", // Default
  ];

  // Social Media
  const facebook = ["bg-[#3b5998] border-[#3b5998] text-white"];
  const twitter = ["bg-[#4ab3f4] border-[#4ab3f4] text-white"];
  const instagram = ["bg-[#517fa4] border-[#517fa4] text-white"];
  const linkedin = ["bg-[#0077b5] border-[#0077b5] text-white"];

  // Outline
  const outlinePrimary = [
    "border-blue-800 text-blue-800", // Default
    "[&:hover:not(:disabled)]:bg-blue-800/10", // On hover and not disabled
  ];
  const outlineSecondary = [
    "border-gray-700 text-gray-700", // Default
    "[&:hover:not(:disabled)]:bg-gray-700/20", // On hover and not disabled
  ];
  const outlineSuccess = [
    "border-green-600 text-green-600", // Default
    "[&:hover:not(:disabled)]:bg-green-600/10", // On hover and not disabled
  ];
  const outlineWarning = [
    "border-yellow-500 text-yellow-500", // Default
    "[&:hover:not(:disabled)]:bg-yellow-500/10", // On hover and not disabled
  ];
  const outlinePending = [
    "border-orange-500 text-orange-500", // Default
    "[&:hover:not(:disabled)]:bg-orange-500/10", // On hover and not disabled
  ];
  const outlineDanger = [
    "border-red-600 text-red-600", // Default
    "[&:hover:not(:disabled)]:bg-red-600/10", // On hover and not disabled
  ];
  const outlineDark = [
    "border-black text-black", // Default
    "[&:hover:not(:disabled)]:bg-black/10", // On hover and not disabled
  ];

  // Soft Color
  const softPrimary = [
    "bg-blue-800 border-blue-800 bg-opacity-20 border-opacity-5 text-blue-800", // Default
    "[&:hover:not(:disabled)]:bg-opacity-10 [&:hover:not(:disabled)]:border-opacity-10", // On hover and not disabled
  ];
  const softSecondary = [
    "bg-gray-700 border-gray-700 bg-opacity-20 text-gray-700", // Default
    "[&:hover:not(:disabled)]:bg-opacity-10", // On hover and not disabled
  ];
  const softSuccess = [
    "bg-green-600 border-green-600 bg-opacity-20 border-opacity-5 text-green-600", // Default
    "[&:hover:not(:disabled)]:bg-opacity-10 [&:hover:not(:disabled)]:border-opacity-10", // On hover and not disabled
  ];
  const softWarning = [
    "bg-yellow-500 border-yellow-500 bg-opacity-20 border-opacity-5 text-yellow-500", // Default
    "[&:hover:not(:disabled)]:bg-opacity-10 [&:hover:not(:disabled)]:border-opacity-10", // On hover and not disabled
  ];
  const softPending = [
    "bg-orange-500 border-orange-500 bg-opacity-20 border-opacity-5 text-orange-500", // Default
    "[&:hover:not(:disabled)]:bg-opacity-10 [&:hover:not(:disabled)]:border-opacity-10", // On hover and not disabled
  ];
  const softDanger = [
    "bg-red-600 border-red-600 bg-opacity-20 border-opacity-5 text-red-600", // Default
    "[&:hover:not(:disabled)]:bg-opacity-10 [&:hover:not(:disabled)]:border-opacity-10", // On hover and not disabled
  ];
  const softDark = [
    "bg-black border-black bg-opacity-20 border-opacity-5 text-black", // Default
    "[&:hover:not(:disabled)]:bg-opacity-10 [&:hover:not(:disabled)]:border-opacity-10", // On hover and not disabled
  ];
</script>

<button
  {...others}
  {type}
  class={twMerge([
    generalStyles,
    variant == "primary" && primary,
    variant == "secondary" && secondary,
    variant == "success" && success,
    variant == "warning" && warning,
    variant == "pending" && pending,
    variant == "danger" && danger,
    variant == "dark" && dark,
    variant == "outline-primary" && outlinePrimary,
    variant == "outline-secondary" && outlineSecondary,
    variant == "outline-success" && outlineSuccess,
    variant == "outline-warning" && outlineWarning,
    variant == "outline-pending" && outlinePending,
    variant == "outline-danger" && outlineDanger,
    variant == "outline-dark" && outlineDark,
    variant == "soft-primary" && softPrimary,
    variant == "soft-secondary" && softSecondary,
    variant == "soft-success" && softSuccess,
    variant == "soft-warning" && softWarning,
    variant == "soft-pending" && softPending,
    variant == "soft-danger" && softDanger,
    variant == "soft-dark" && softDark,
    variant == "facebook" && facebook,
    variant == "twitter" && twitter,
    variant == "instagram" && instagram,
    variant == "linkedin" && linkedin,
    className,
  ])}
>
  {@render children()}
</button>
