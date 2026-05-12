<script setup>
import { useEditor, EditorContent } from '@tiptap/vue-3'
import StarterKit from '@tiptap/starter-kit'
import { watch, onBeforeUnmount } from 'vue'

const props = defineProps({
  modelValue: {
    type: String,
    default: '',
  },
})

const emit = defineEmits(['update:modelValue'])

const editor = useEditor({
  extensions: [
    StarterKit,
  ],
  content: props.modelValue,
  onUpdate: () => {
    emit('update:modelValue', editor.value.getHTML())
  },
  editorProps: {
    attributes: {
      class: 'prose max-w-none focus:outline-none min-h-[100px] text-sm',
    },
  },
})

watch(() => props.modelValue, (value) => {
  const isSame = editor.value.getHTML() === value
  if (isSame) {
    return
  }
  editor.value.commands.setContent(value, false)
})

onBeforeUnmount(() => {
  editor.value.destroy()
})
</script>

<template>
  <div v-if="editor" class="border-2 border-black flex flex-col bg-white">
    <!-- Toolbar -->
    <div class="flex flex-wrap gap-1 border-b-2 border-black p-1 bg-[#f3f3f3]">
      <button type="button" @click="editor.chain().focus().toggleBold().run()" :class="{ 'bg-black text-white': editor.isActive('bold'), 'bg-white text-black': !editor.isActive('bold') }" class="border-2 border-black w-8 h-8 flex items-center justify-center font-bold hover:bg-gray-200 transition-colors">
        B
      </button>
      <button type="button" @click="editor.chain().focus().toggleItalic().run()" :class="{ 'bg-black text-white': editor.isActive('italic'), 'bg-white text-black': !editor.isActive('italic') }" class="border-2 border-black w-8 h-8 flex items-center justify-center font-serif italic hover:bg-gray-200 transition-colors">
        I
      </button>
      <button type="button" @click="editor.chain().focus().toggleBulletList().run()" :class="{ 'bg-black text-white': editor.isActive('bulletList'), 'bg-white text-black': !editor.isActive('bulletList') }" class="border-2 border-black px-2 h-8 flex items-center justify-center font-bold text-xs hover:bg-gray-200 transition-colors" title="Bullet List">
        <span class="material-symbols-outlined text-[16px]">format_list_bulleted</span>
      </button>
      <button type="button" @click="editor.chain().focus().toggleOrderedList().run()" :class="{ 'bg-black text-white': editor.isActive('orderedList'), 'bg-white text-black': !editor.isActive('orderedList') }" class="border-2 border-black px-2 h-8 flex items-center justify-center font-bold text-xs hover:bg-gray-200 transition-colors" title="Ordered List">
        <span class="material-symbols-outlined text-[16px]">format_list_numbered</span>
      </button>
    </div>
    
    <!-- Editor Content -->
    <div class="p-3">
      <editor-content :editor="editor" />
    </div>
  </div>
</template>

<style>
/* TipTap Basic Styles inside the editor */
.ProseMirror p {
  margin: 0;
  padding: 0;
}
.ProseMirror ul {
  list-style-type: disc;
  padding-left: 1.2rem;
  margin-top: 0.2rem;
  margin-bottom: 0.2rem;
}
.ProseMirror ol {
  list-style-type: decimal;
  padding-left: 1.2rem;
  margin-top: 0.2rem;
  margin-bottom: 0.2rem;
}
</style>
