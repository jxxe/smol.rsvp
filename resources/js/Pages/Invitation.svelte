<script lang="ts">
    import { useForm } from '@inertiajs/svelte';
    import { Icon } from '@steeze-ui/svelte-icon';
    import { Loader4 } from '@steeze-ui/remix-icons';
    import { isHexLight } from '../helpers/helpers';
    import { classes } from '../helpers/classes';

    export let invitation;

    let isEmbed = window.self !== window.top;
    if(isEmbed) delete invitation.description;

    const color = invitation.custom_color ?? '#3b82f6';
    const textColorClass = isHexLight(color) ? 'text-black' : 'text-white';

    let form = useForm({
        email: null,
        email_part: null,
        invitation: invitation.slug
    });

    let isDone = false;
    let imageLoaded = false;

    function submit() {
        $form.post('/api/accept-invitation', {
            onSuccess() {
                isDone = true;

                if(invitation.redirect_url) {
                    setTimeout(() => {
                        (isEmbed ? parent : window).location = invitation.redirect_url;
                    }, 750);
                }
            },
            onError: () =>  alert('Something went wrong')
        });
    }

    function replaceLineBreaks(text) {
        return '<p>' + text.replaceAll('\n', '</p><p>') + '</p>';
    }
</script>

<svelte:head>
    <title>{invitation.title} — smol.rsvp</title>
    <meta name="robots" content="noindex">
</svelte:head>

<div style="--color: {color}; --color-light: {color + '26'}"
    class="bg-[var(--color)] h-screen grid place-items-center content-center gap-4 p-4 bg-cover bg-center">
    {#if invitation.image_url}
        <img on:load={() => imageLoaded = true} src={invitation.image_url} alt="" class:opacity-50={imageLoaded} draggable="false"
            class={classes('grayscale object-cover w-full h-full fixed top-0 left-0', {
                'transition-opacity opacity-0 duration-[3s] delay-250': !new URLSearchParams(location.search).has('noAnimate')
            })}>
    {/if}

    <div class="bg-white border rounded-lg overflow-hidden md:flex z-10 shadow">
        <div class="p-6 space-y-4 flex flex-col justify-between max-w-md">
            {#if invitation.logo}
                <div>
                    <img class="w-36" {...invitation.logo} alt="">
                </div>
            {/if}

            <div class="space-y-2 overflow-scroll">
                <h2 class="text-2xl font-bold leading-tight">{invitation.title}</h2>

                {#if invitation.description}
                    <div class="text-gray-400 leading-tight space-y-2">
                        {@html replaceLineBreaks(invitation.description)}
                    </div>
                {/if}
            </div>

            {#if isDone}
                <p>Check your email for an invitation!</p>
            {:else}
                <form class:pointer-events-none={$form.processing} class:opacity-75={$form.processing} on:submit|preventDefault={submit} class="flex lg:flex-row flex-col gap-2">
                    <label class="w-full">
                        {#if invitation.email_domain}
                            <div class="input flex focus-within:border-[var(--color)] ring-[var(--color-light)] focus-within:ring transition-all">
                                <input bind:value={$form.email_part} class="plain-input" required placeholder="yourname" type="text">
                                <span>@{ invitation.email_domain }</span>
                            </div>
                        {:else}
                            <input bind:value={$form.email} class="focus:!border-[var(--color)] !ring-[var(--color-light)]" required type="email" placeholder="ceo@profit.biz">
                        {/if}
                    </label>

                    <button class="{textColorClass} relative bg-[var(--color)] border border-[var(--color)] rounded-lg px-4 py-2 shadow-sm transition-all" type="submit">
                        <div class:opacity-100={$form.processing} class="opacity-0 absolute top-1/2 left-1/2 -translate-y-1/2 -translate-x-1/2">
                            <Icon class="w-5 animate-spin" src={Loader4}/>
                        </div>

                        <span class:opacity-0={$form.processing}>Invite</span>
                    </button>
                </form>
            {/if}
        </div>
    </div>

    <p class="text-xs bg-white px-3 py-1 rounded-full border z-10">
        Created with <a class="text-[var(--color)] underline" href="/">smol.rsvp</a>
    </p>
</div>