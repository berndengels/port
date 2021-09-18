
export default {
    methods: {
        chunks(arr, size) {
            if (size < 1) throw new Error('Size must be positive')
            const result = []
            for (let i = 0; i < arr.length; i += size) {
                result.push(arr.slice(i, i + size))
            }
            return result
        }
    }
}
