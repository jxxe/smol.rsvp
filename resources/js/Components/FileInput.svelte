<script>
    import { Icon } from '@steeze-ui/svelte-icon';
    import { ArrowUpTray, Trash } from '@steeze-ui/heroicons';
    import Button from './Button.svelte';

    export let value;
    export let accept = '';

    function pickFile() {
        if(value) {
            value = '';
            return;
        }

        let element = document.createElement('input');
        element.type = 'file';
        element.accept = accept;
        element.addEventListener('change', () => value = element.files[0]);
        element.click();
    }
</script>

<Button action={event => {
    event.preventDefault();
    pickFile();
}} class="text-left flex gap-2 items-center w-full !px-3">
    <Icon class="{value ? 'text-red-500' : 'text-blue-500'} w-4" theme={value ? 'outlined' : 'mini'} src={value ? Trash : ArrowUpTray}/>
    <span class="truncate">{value ? value.name : 'Upload File'}</span>
</Button>