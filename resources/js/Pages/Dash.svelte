<svelte:head>
    <title>Dashboard — smol.rsvp</title>
</svelte:head>

<script>
    import Modal from '../Components/Modal.svelte';
    import InvitationForm from '../Components/InvitationForm.svelte';
    import { Icon } from '@steeze-ui/svelte-icon';
    import { QrCode, Trash, Eye, Plus } from '@steeze-ui/heroicons';
    import { inertia } from '@inertiajs/svelte';

    export let invitations = [];
    let isOpen = false;

    function getQrUrl({ slug, hex_color }) {
        let result = 'https://api.qrserver.com/v1/create-qr-code/?data=';
        result += encodeURIComponent(`https://smol.rsvp/invitation/${slug}`);
        result += '&bgcolor=fff&color=';
        result += hex_color?.replace('#', '') ?? '000';
        return result;
    }
</script>

<Modal bind:isOpen={isOpen} closeWithEsc={false}>
    <InvitationForm onSuccess={() => isOpen = false}/>
</Modal>

{#if invitations.length}
    <div>
        <button on:click={() => isOpen = true}>New Invitation</button>

        <div class="shadow-sm rounded-lg overflow-hidden border divide-y">
            {#each invitations as invitation}
                <div class="flex items-center justify-between">
                    <a href="/invitation/{invitation.slug}" class="font-bold truncate px-4">{invitation.title}</a>

                    <div class="flex items-center divide-x leading-none">
                        <span class="px-4 py-3 flex items-center gap-1">
                            <Icon class="w-4 text-green-500" src={Eye} theme="mini"/>
                            <span>{invitation.views}</span>
                            <span class="hidden sm:inline">view{invitation.views !== 1 ? 's' : ''}</span>
                        </span>

                        <a class="px-4 py-3 flex items-center gap-1 hover:bg-gray-100 transition-colors" href={getQrUrl(invitation)} target="_blank" rel="noreferrer">
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