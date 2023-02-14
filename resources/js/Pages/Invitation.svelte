<script>
    import { useForm } from '@inertiajs/svelte';
    import { Icon } from '@steeze-ui/svelte-icon';
    import { Loader4 } from '@steeze-ui/remix-icons';

    import Button from '../Components/Button.svelte';
    export let invitation;

    let form = useForm({
        email: null,
        email_part: null,
        invitation: invitation.slug
    });

    let isDone = false;

    function submit() {
        $form.post('/api/accept-invitation', {
            onSuccess() {
                isDone = true;

                if(invitation.redirect_url) {
                    setTimeout(() => {
                        window.location = invitation.redirect_url;
                    }, 1000);
                }
            }
        });
    }

    // redirect_url
</script>

<svelte:head>
    <title>Please RSVP for {invitation.title} — smol.rsvp</title>
    <meta name="robots" content="noindex">
</svelte:head>

<div class="h-screen bg-gray-100 grid place-items-center content-center gap-4 p-4">
    <div class="bg-white {invitation.image_url && 'max-w-screen-lg md:aspect-[7/3]'} border rounded-lg overflow-hidden md:flex">
        {#if invitation.image_url}
            <img class="aspect-[4/3] object-cover" src={invitation.image_url} alt="">
        {/if}
    
        <div class="p-6 space-y-4 flex flex-col justify-between {invitation.image_url || 'max-w-md'}">
            {#if invitation.logo_url}
                <div>
                    <img class="w-40" src={invitation.logo_url} alt="">
                </div>
            {/if}

            <div class="space-y-2">
                <h2 class="text-2xl font-bold leading-tight">{invitation.title}</h2>

                {#if invitation.description}
                    <p class="text-gray-400 leading-tight">{invitation.description}</p>
                {/if}
            </div>

            {#if isDone}
                <p>Check your email for an invitation!</p>
            {:else}
                <form class:pointer-events-none={$form.processing} class:opacity-75={$form.processing} on:submit|preventDefault={submit} class="flex lg:flex-row flex-col gap-2">
                    <label class="w-full">
                        {#if invitation.email_domain}
                            <div class="input flex">
                                <input bind:value={$form.email_part} class="plain-input" required placeholder="yourname" type="text">
                                <span>@{ invitation.email_domain }</span>
                            </div>
                        {:else}
                            <input bind:value={$form.email} required type="email" placeholder="ceo@profit.biz">
                        {/if}
                    </label>
                    
                    <Button class="relative" primary={true}>
                        <div class:opacity-100={$form.processing} class="opacity-0 absolute top-1/2 left-1/2 -translate-y-1/2 -translate-x-1/2">
                            <Icon class="w-5 animate-spin" src={Loader4}/>
                        </div>

                        <span class:opacity-0={$form.processing}>Submit</span>
                    </Button>
                </form>
            {/if}
        </div>
    </div>

    <p class="text-sm">Created with <a class="text-blue-500 underline" href="/">smol.rsvp</a> by <a class="text-blue-500 underline" href="https://jero.zone">Jerome Paulos</a></p>
</div>