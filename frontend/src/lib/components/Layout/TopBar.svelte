<script lang="ts">
  import Breadcrumb from "$lib/components/Breadcrumb";
  import Lucide from "$lib/components/Lucide";

  import {
    formHandler,
    generateUserAvatar,
    getColorFromString,
  } from "$lib/functions";
  import { enhance } from "$app/forms";

  import { user } from "@/stores/user";

  const { name } = user();
</script>

<!-- BEGIN: Top Bar -->
<div class="h-[67px] flex items-center relative border-b border-slate-200">
  <!-- BEGIN: Breadcrumb -->
  <Breadcrumb class="hidden mr-auto -intro-x sm:flex">
    <Breadcrumb.Link to="/">Uygulama</Breadcrumb.Link>
    <Breadcrumb.Link to="/panel" active={true}>Panel</Breadcrumb.Link>
  </Breadcrumb>
  <div class="flex items-start gap-3">
    <a
      class={`w-8 h-8 text-white  overflow-hidden rounded-full shadow-lg  zoom-in intro-x flex items-center justify-center`}
      style={`background-color:#${getColorFromString(name)}`}
      href="/panel/profile"
    >
      {generateUserAvatar(name)}
    </a>
    <form
      use:enhance={() =>
        async ({ result }) =>
          formHandler(result)}
      method="post"
      action="?/logout"
      class="intro-x"
    >
      <button class="w-full hover:text-danger transition-all">
        <Lucide icon="LogOut" class="w-8 h-8 mr-2" />
      </button>
    </form>
  </div>
</div>
<!-- END: Top Bar -->
