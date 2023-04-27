<script lang="ts">
    import { Icon } from '@steeze-ui/svelte-icon';
    import type { IconSource } from '@steeze-ui/svelte-icon/types';
    import { classes } from '../helpers/classes';

    export let style: 'default'|'destructive'|'primary' = 'default';
    export let href = '';
    export let submit = false;
    export let disabled = false;
    
    export let icon: IconSource = null;
    export let iconTheme = '';
    export let iconClass = '';

    $: fullIconClass = classes('w-4', {
        [iconClass]: true,
        'text-blue-500': style === 'default'
    });

    $: className = classes('border rounded-lg px-4 py-2 shadow-sm transition-all', {
        [$$props.class]: true,
        'flex gap-3 items-center text-left': !!icon,
        'pointer-events-none opacity-75 cursor-not-allowed': disabled,
        'bg-blue-500 text-white border-blue-500': style === 'primary',
        'bg-red-500 text-white border-red-500': style === 'destructive',
        'bg-white hover:bg-gray-100': style === 'default'
    });
</script>

{#if href}
    <a {href} class={className}>
        {#if icon} <Icon src={icon} class={fullIconClass} theme={iconTheme}/> {/if}
        <span class="truncate"><slot/></span>
    </a>
{:else}
    <button type={submit ? 'submit' : 'button'} class={className} on:click>
        {#if icon} <Icon src={icon} class={fullIconClass} theme={iconTheme}/> {/if}
        <span class="truncate"><slot/></span>
    </button>
{/if}