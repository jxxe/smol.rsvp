<script>
    import Logo from './Logo.svelte';
</script>

<div class="p-4">
    <main class="p-4 max-w-screen-sm mx-auto space-y-4">
        <header>
            <div class="mx-auto w-fit">
                <Logo/>
            </div>
        </header>
    
        <div>
            <slot/>
        </div>
    </main>
</div>