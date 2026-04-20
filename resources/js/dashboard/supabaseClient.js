import { createClient } from '@supabase/supabase-js'

// Kinukuha nito ang credentials mula sa iyong .env file
const supabaseUrl = import.meta.env.VITE_SUPABASE_URL
const supabaseKey = import.meta.env.VITE_SUPABASE_ANON_KEY

export const supabase = createClient(supabaseUrl, supabaseKey)