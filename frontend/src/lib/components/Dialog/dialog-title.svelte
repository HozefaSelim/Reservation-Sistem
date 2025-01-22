<script lang="ts">
	import { Dialog as DialogPrimitive } from 'bits-ui';
	import { cn } from '$lib/utils.js';

	type $$Props = DialogPrimitive.TitleProps;

	let className: $$Props['class'] = undefined;
	export { className as class };
</script>

<DialogPrimitive.Title
	class={cn(
		'flex items-center px-5 py-3 border-b border-slate-200/60 dark:border-darkmode-400',
		className
	)}
	{...$$restProps}
>
	<slot />
</DialogPrimitive.Title>
