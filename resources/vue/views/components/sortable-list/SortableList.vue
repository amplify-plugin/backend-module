<template>
    <div class="sortable-list-root">
        <p v-if="hint" class="text-muted small px-3 mb-2">{{ hint }}</p>
        <slot name="hint" />

        <transition-group
            :name="transitionName"
            tag="div"
            class="sortable-list"
            :class="{ 'is-sorting': draggedIndex !== null }"
        >
            <div
                v-for="(item, index) in items"
                :key="getItemKey(item, index)"
                class="sortable-item"
                :class="itemWrapperClass(item, index)"
                @dragover.prevent="onDragOver($event, index)"
                @drop.prevent="onDrop(index)"
            >
                <slot
                    name="item"
                    :item="item"
                    :index="index"
                    :is-dragging="draggedIndex === index"
                    :is-just-dropped="justDroppedKey === getItemKey(item, index)"
                    :drag-start="onDragStart"
                    :drag-end="onDragEnd"
                />
            </div>
        </transition-group>
    </div>
</template>

<script>
/**
 * Reusable drag-and-drop reorder list.
 *
 * Mutates `items` in place (splice) and optionally writes 1-based `order`.
 * Pair with <sortable-handle> inside the item slot (pass dragStart / dragEnd from the slot).
 *
 * @example
 * <sortable-list
 *   :items="rows"
 *   item-key="_uid"
 *   order-key="order"
 *   hint="Drag the handle to change order."
 *   ghost-selector=".card"
 *   item-class="form-group col-sm-12"
 *   @before-reorder="onBeforeReorder"
 *   @reorder="onReorder"
 * >
 *   <template #item="{ item, index, dragStart, dragEnd }">
 *     <div class="card">
 *       <sortable-handle :index="index" align="fields" :drag-start="dragStart" :drag-end="dragEnd" />
 *       {{ item.name }}
 *     </div>
 *   </template>
 * </sortable-list>
 */
export default {
    name: 'SortableList',

    props: {
        items: {
            type: Array,
            required: true,
        },
        itemKey: {
            type: String,
            default: '_uid',
        },
        orderKey: {
            type: String,
            default: 'order',
        },
        orderStart: {
            type: Number,
            default: 1,
        },
        hint: {
            type: String,
            default: '',
        },
        itemClass: {
            type: String,
            default: '',
        },
        ghostSelector: {
            type: String,
            default: '',
        },
        transitionName: {
            type: String,
            default: 'sortable',
        },
        disabled: {
            type: Boolean,
            default: false,
        },
    },

    data() {
        return {
            draggedIndex: null,
            dragOverIndex: null,
            dropPosition: 'before',
            justDroppedKey: null,
            dragGhost: null,
        };
    },

    beforeDestroy() {
        this.clearDragGhost();
    },

    methods: {
        getItemKey(item, index) {
            const key = item && item[this.itemKey];
            return key != null && key !== '' ? key : `sortable-index-${index}`;
        },

        itemWrapperClass(item, index) {
            return [
                this.itemClass,
                {
                    'is-dragging': this.draggedIndex === index,
                    'is-drop-before':
                        this.dragOverIndex === index &&
                        this.draggedIndex !== index &&
                        this.dropPosition === 'before',
                    'is-drop-after':
                        this.dragOverIndex === index &&
                        this.draggedIndex !== index &&
                        this.dropPosition === 'after',
                    'is-just-dropped': this.justDroppedKey === this.getItemKey(item, index),
                },
            ];
        },

        reindexOrder() {
            if (!this.orderKey) {
                return;
            }

            this.items.forEach((item, index) => {
                item[this.orderKey] = this.orderStart + index;
            });
        },

        resolveGhostSource(event) {
            const itemEl = event.currentTarget.closest('.sortable-item');
            if (!itemEl) {
                return event.currentTarget;
            }

            if (!this.ghostSelector) {
                return itemEl;
            }

            return itemEl.querySelector(this.ghostSelector) || itemEl;
        },

        onDragStart(event, index) {
            if (this.disabled) {
                event.preventDefault();
                return;
            }

            this.draggedIndex = index;
            event.dataTransfer.effectAllowed = 'move';
            event.dataTransfer.setData('text/plain', String(index));

            const source = this.resolveGhostSource(event);
            if (!source) {
                return;
            }

            const ghost = source.cloneNode(true);
            ghost.classList.add('sortable-drag-ghost');
            ghost.style.position = 'absolute';
            ghost.style.top = '-1000px';
            ghost.style.left = '-1000px';
            ghost.style.width = `${source.offsetWidth}px`;
            ghost.style.opacity = '0.95';
            ghost.style.boxShadow = '0 18px 40px rgba(15, 23, 42, 0.22)';
            ghost.style.transform = 'rotate(1.5deg) scale(1.02)';
            ghost.style.pointerEvents = 'none';
            document.body.appendChild(ghost);
            event.dataTransfer.setDragImage(ghost, 36, 28);
            this.dragGhost = ghost;

            this.$emit('drag-start', { index, item: this.items[index] });
        },

        onDragOver(event, index) {
            if (this.disabled || this.draggedIndex === null || this.draggedIndex === index) {
                this.dragOverIndex = null;
                return;
            }

            const rect = event.currentTarget.getBoundingClientRect();
            this.dropPosition = event.clientY < rect.top + rect.height / 2 ? 'before' : 'after';
            this.dragOverIndex = index;
        },

        onDrop(index) {
            if (this.disabled || this.draggedIndex === null || this.draggedIndex === index) {
                return;
            }

            const fromIndex = this.draggedIndex;
            let toIndex = this.dropPosition === 'after' ? index + 1 : index;
            if (fromIndex < toIndex) {
                toIndex -= 1;
            }

            if (fromIndex === toIndex) {
                this.resetDragState();
                return;
            }

            this.$emit('before-reorder', {
                fromIndex,
                toIndex,
                length: this.items.length,
                item: this.items[fromIndex],
            });

            const [moved] = this.items.splice(fromIndex, 1);
            this.items.splice(toIndex, 0, moved);
            this.reindexOrder();

            const droppedKey = this.getItemKey(moved, toIndex);
            this.justDroppedKey = droppedKey;
            window.setTimeout(() => {
                if (this.justDroppedKey === droppedKey) {
                    this.justDroppedKey = null;
                }
            }, 800);

            this.$emit('reorder', {
                items: this.items,
                fromIndex,
                toIndex,
                item: moved,
            });

            this.resetDragState();
        },

        onDragEnd() {
            this.resetDragState();
            this.$emit('drag-end');
        },

        resetDragState() {
            this.draggedIndex = null;
            this.dragOverIndex = null;
            this.clearDragGhost();
        },

        clearDragGhost() {
            if (this.dragGhost && this.dragGhost.parentNode) {
                this.dragGhost.parentNode.removeChild(this.dragGhost);
            }
            this.dragGhost = null;
        },
    },
};
</script>

<style scoped>
.sortable-list.is-sorting ::v-deep .card {
    transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease, background-color 0.2s ease;
}

.sortable-move {
    transition: transform 0.32s cubic-bezier(0.22, 1, 0.36, 1);
}

.sortable-item {
    position: relative;
    min-width: 0;
    width: 100%;
}

.sortable-item.is-dragging {
    opacity: 0.4;
    transform: scale(0.98);
}

.sortable-item.is-dragging ::v-deep .card {
    box-shadow: none;
}

.sortable-item.is-drop-before::before,
.sortable-item.is-drop-after::after {
    content: '';
    position: absolute;
    left: 12px;
    right: 12px;
    height: 4px;
    border-radius: 999px;
    background: #42ba96;
    box-shadow: 0 0 0 4px rgba(66, 186, 150, 0.18);
    z-index: 2;
    animation: sortable-drop-pulse 0.9s ease-in-out infinite;
}

.sortable-item.is-drop-before::before {
    top: -2px;
}

.sortable-item.is-drop-after::after {
    bottom: 10px;
}

.sortable-item.is-just-dropped ::v-deep .card {
    animation: sortable-dropped 0.7s ease;
}

@keyframes sortable-drop-pulse {
    0%,
    100% {
        transform: scaleX(1);
        opacity: 1;
    }
    50% {
        transform: scaleX(0.96);
        opacity: 0.7;
    }
}

@keyframes sortable-dropped {
    0% {
        box-shadow: 0 0 0 0 rgba(66, 186, 150, 0.45);
        border-color: #42ba96;
    }
    100% {
        box-shadow: 0 0 0 12px rgba(66, 186, 150, 0);
        border-color: rgba(0, 0, 0, 0.125);
    }
}
</style>
