<script context="module" lang="ts">
	import { getContext } from 'svelte';
	import type { HTMLLiAttributes } from 'svelte/elements';
	import { type KeyContext, type BreadcrumbContext } from './Breadcrumb.svelte';
	import clsx from 'clsx';

	export interface LinkProps extends HTMLLiAttributes {
		className?: string;
		to?: string;
		active?: boolean;
	}
</script>

<script lang="ts">
	let className: LinkProps['className'] = undefined;
	let to: LinkProps['to'] = undefined;
	let active: LinkProps['active'] = undefined;

	export { className as class, to, active };

	const { getKey } = getContext<KeyContext>('key');
	let key = getKey();

	const breadcrumb = getContext<BreadcrumbContext>('breadcrumb');
</script>

<li
	{...$$props}
	class={clsx([
		className,
		key > 0 && 'relative ml-5 pl-0.5',
		!breadcrumb.light &&
			key > 0 &&
			"before:content-[''] before:w-[14px] before:h-[14px] before:bg-chevron-black before:transform before:rotate-[-90deg] before:bg-[length:100%] before:-ml-[1.125rem] before:absolute before:my-auto before:inset-y-0",
		breadcrumb.light &&
			key > 0 &&
			"before:content-[''] before:w-[14px] before:h-[14px] before:bg-chevron-white before:transform before:rotate-[-90deg] before:bg-[length:100%] before:-ml-[1.125rem] before:absolute before:my-auto before:inset-y-0",
		key > 0 && 'dark:before:bg-bredcrumb-chevron-darkmode',
		!breadcrumb.light && active && 'text-slate-800 cursor-text dark:text-slate-400',
		breadcrumb.light && active && 'text-white/70'
	])}
>
	<a href={to}><slot /></a>
</li>
