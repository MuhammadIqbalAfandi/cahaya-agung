import { ref } from 'vue'

export function useSearchText(props) {
  const search = ref(props.initialSearch)

  return {
    search,
  }
}
