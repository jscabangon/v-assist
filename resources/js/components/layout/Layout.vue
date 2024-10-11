<template>
    <div>
        <Header />
        
        <Content>
            <slot></slot>
        </Content>
    </div>
</template>

<script>
import Header from './Header.vue';
import Content from './Content.vue';

export default {
    name: 'Layout',
    components: {
        Header,
        Content
    }
}
</script>