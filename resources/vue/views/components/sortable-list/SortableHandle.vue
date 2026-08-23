<template>
    <div
        class="sortable-handle"
        :class="{ 'is-fields': align === 'fields' }"
        draggable="true"
        :title="title"
        role="button"
        :aria-label="title"
        @dragstart="onDragStart"
        @dragend="onDragEnd"
    >
        <slot>
            <span class="sortable-grip" aria-hidden="true">
                <span></span><span></span><span></span>
                <span></span><span></span><span></span>
            </span>
        </slot>
    </div>
</template>

<script>
/**
 * Drag handle for SortableList. Must be rendered inside a SortableList item slot.
 *
 * @example
 * <template #item="{ item, index, dragStart, dragEnd }">
 *   <sortable-handle :index="index" align="fields" :drag-start="dragStart" :drag-end="dragEnd" />
 * </template>
 */
export default {
    name: 'SortableHandle',

    props: {
        index: {
            type: Number,
            required: true,
        },
        title: {
            type: String,
            default: 'Drag to reorder',
        },
        align: {
            type: String,
            default: 'start',
            validator(value) {
                return value === 'start' || value === 'fields';
            },
        },
        dragStart: {
            type: Function,
            default: null,
        },
        dragEnd: {
            type: Function,
            default: null,
        },
    },

    methods: {
        onDragStart(event) {
            if (!this.dragStart) {
                event.preventDefault();
                return;
            }

            this.dragStart(event, this.index);
        },

        onDragEnd() {
            if (this.dragEnd) {
                this.dragEnd();
            }
        },
    },
};
</script>

<style scoped>
.sortable-handle {
    cursor: grab;
    user-select: none;
    width: 28px;
    min-width: 28px;
    color: #6c757d;
    text-align: center;
    flex-shrink: 0;
    transition: color 0.2s ease, transform 0.2s ease;
}

.sortable-handle.is-fields {
    padding-top: 2rem;
}

.sortable-handle:hover {
    color: #42ba96;
    transform: scale(1.08);
}

.sortable-handle:active {
    cursor: grabbing;
}

.sortable-grip {
    display: grid;
    grid-template-columns: repeat(2, 5px);
    gap: 4px;
    justify-content: center;
    margin: 0 auto;
}

.sortable-grip span {
    width: 5px;
    height: 5px;
    border-radius: 50%;
    background: currentColor;
    display: block;
}
</style>
