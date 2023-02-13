<script>
    import { useForm } from '@inertiajs/svelte';
    import FileInput from '../Components/FileInput.svelte';
    import Button from './Button.svelte';

    export let onSuccess = () => {};

    export let values = {
        title: '',
        description: '',

        calendar_id: '',
        event_id: '',

        email_domain: '',
        logo: null,
        image: null,
        redirect_url: ''
    };

    let calendars = null;
    let events = null;
    let form = useForm(values);

    (async function fetchCalendars() {
        const response = await fetch('/api/calendars');
        calendars = await response.json();
        $form.calendar_id = calendars.length ? calendars[0].id : '';
        await fetchEvents();
    })()

    async function fetchEvents() {
        if(!$form.calendar_id) return;
        events = null;
        const response = await fetch(`/api/events?calendar=${$form.calendar_id}`);
        events = await response.json();
        $form.event_id = events.length ? events[0].id : '';
    }

    function submit() {
        $form.post('/invitations', { onSuccess });
    }
</script>

<style>
    label:has([required]) > span::after {
        content: '*';
        color: theme('colors.red.500');
    }
</style>

<!-- svelte-ignore a11y-label-has-associated-control a11y-click-events-have-key-events -->
<form class:pointer-events-none={$form.processing} on:submit|preventDefault={submit} action="/invitation" method="POST">
    <div class="grid gap-2 sm:grid-cols-2 p-4">
        <label class="col-span-full">
            <span>Invitation Title</span>
            <input autofocus required bind:value={$form.title} placeholder="Enterprise Business Meeting" type="text">
        </label>
    
        <label>
            <span>Calendar</span>
    
            <select required bind:value={$form.calendar_id} on:change={fetchEvents}>
                {#if calendars !== null}
                    {#each calendars as calendar}
                        <option value={calendar.id}>{calendar.title}</option>
                    {:else}
                        <option value="" selected disabled>No Calendars</option>
                    {/each}
                {/if}
            </select>
        </label>
    
        <label>
            <span>Event</span>
    
            <select required bind:value={$form.event_id}>
                {#if events !== null}
                    {#each events as event}
                        <option value={event.id}>{event.title} ({event.date})</option>
                    {:else}
                        <option value="" selected disabeld>No Events</option>
                    {/each}
                {/if}
            </select>
        </label>
    
        <label class="col-span-full">
            <span>Description</span>
            <textarea placeholder="Key stakeholders will convene to strategically analyze performance indicators, evaluate operational efficiencies, and synergistically brainstorm actionable insights to enhance stakeholder value." bind:value={$form.description} rows="3"></textarea>
        </label>

        <label>
            <span>Custom Logo</span>
            <FileInput accept=".png,.jpg,.jpeg" bind:value={$form.logo}/>
        </label>

        <label>
            <span>Display Image</span>
            <FileInput accept=".png,.jpg,.jpeg" bind:value={$form.image}/>
        </label>

        <label>
            <span title="Only emails ending in @{$form.email_domain || 'profit.biz'} can RSVP">Limit to Email Domain</span>
            <input bind:value={$form.email_domain} placeholder="profit.biz" type="text">
        </label>

        <label>
            <span>Redirect After RSVP</span>
            <input bind:value={$form.redirect_url} placeholder="https://profit.biz/confirm" type="url">
        </label>
    </div>

    <div class="p-4 bg-gray-100">
        <Button class="w-full {$form.processing ? 'animate-pulse' : ''}" primary={true}>Create Invitation</Button>
    </div>
</form>