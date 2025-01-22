<script lang="ts">
  const { title, description } = $props();
</script>

<h2 class="text-2xl font-bold text-center intro-x xl:text-3xl xl:text-left">
  {title}
</h2>
<div class="mt-2 text-center intro-x text-slate-400 xl:hidden">
  {description}
</div>
