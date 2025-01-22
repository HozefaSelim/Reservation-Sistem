import Breadcrumb from "./Breadcrumb.svelte";
import Link from "./Link.svelte";

const BreadcrumbComponent = Object.assign(Breadcrumb, {
  Link: Link,
});

export default BreadcrumbComponent;
