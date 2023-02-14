<svelte:head>
    <title>Dashboard — smol.rsvp</title>
</svelte:head>

<script context="module">
    export { default as layout } from '../Components/Layout.svelte'
</script>

<script>
    import InvitationForm from '../Components/InvitationForm.svelte';
    import { Icon } from '@steeze-ui/svelte-icon';
    import { Plus, QrCode, Trash } from '@steeze-ui/heroicons';
    import { CalendarCheck } from '@steeze-ui/remix-icons';
    import { inertia } from '@inertiajs/svelte';

    export let invitations = [];

    function getQrUrl(slug) {
        let result = 'https://api.qrserver.com/v1/create-qr-code/?data=';
        result += encodeURIComponent(`https://smol.rsvp/invitation/${slug}`);
        return result;
    }
</script>

{#if invitations.length}
    <div>
        <div class="shadow-sm rounded-lg overflow-hidden border divide-y">
            {#each invitations as invitation}
                <div class="flex items-center justify-between">
                    <a href="/invitation/{invitation.slug}" class="font-bold truncate px-4">{invitation.title}</a>

                    <div class="flex items-center divide-x leading-none">
                        <span class="px-4 py-3 flex items-center gap-1">
                            <Icon class="w-4 text-green-500" src={CalendarCheck} theme="solid"/>
                            <span>{invitation.rsvps}</span>
                            <span class="hidden sm:inline">RSVP{invitation.rsvps !== 1 ? 's' : ''}</span>
                        </span>

                        <a class="px-4 py-3 flex items-center gap-1 hover:bg-gray-100 transition-colors" href={getQrUrl(invitation.slug)} target="_blank" rel="noreferrer">
                            <Icon class="w-4 text-blue-500" src={QrCode} theme="mini"/>
                            <span class="hidden sm:inline">QR Code</span>
                        </a>

                        <button class="px-4 py-3 flex items-center gap-1 hover:bg-gray-100 transition-colors" use:inertia={{ href: `/invitations/${invitation.slug}`, method: 'delete' }}>
                            <Icon class="w-4 text-red-500" src={Trash} theme="mini"/>
                            <span class="hidden sm:inline">Delete</span>
                        </button>
                    </div>
                </div>
            {/each}
        </div>
    </div>
{:else}
    <div class="border rounded-lg overflow-hidden">
        <InvitationForm/>
    </div>
{/if}

<footer class="mt-4">
    <p class="text-sm text-center">by <a class="underline text-blue-500" href="https://jero.zone">Jerome Paulos</a></p>
</footer>