import { resolve } from 'node:path'
import { fileURLToPath } from 'node:url'
import { defineConfig } from 'kirbyup/config'

const currentDir = fileURLToPath(new URL('.', import.meta.url))

export default defineConfig({
  alias: {
    '@/': `${resolve(currentDir, 'kirby/panel/src')}/`
  },
  vite: {
    server: {
      host: '127.0.0.1',
      cors: true
    }
  }
})
