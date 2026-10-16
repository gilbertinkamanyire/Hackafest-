<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Gemini / Gemma AI Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Google AI Studio (Gemini/Gemma) integration in
    | eWitnessVault for AI-powered evidence analysis and case summarization.
    |
    | Get your FREE API key at: https://aistudio.google.com/app/apikey
    |
    */

    // Supports both GEMINI_API_KEY and legacy GEMMA_API_KEY
    'api_key' => env('GEMINI_API_KEY', env('GEMMA_API_KEY')),

    'model' => env('GEMINI_MODEL', 'gemini-3.5-flash'),

    // Base URL — model and key are appended dynamically in GemmaService
    'base_url' => 'https://generativelanguage.googleapis.com/v1beta/models',

    'timeout' => env('GEMINI_TIMEOUT', 30),

    'max_tokens' => env('GEMINI_MAX_TOKENS', 2048),

    'temperature' => env('GEMINI_TEMPERATURE', 0.3),

    /*
    |--------------------------------------------------------------------------
    | AI Feature Flags
    |--------------------------------------------------------------------------
    |
    | Enable/disable specific AI features in the application.
    |
    */

    'features' => [
        'evidence_analysis' => env('GEMMA_FEATURE_EVIDENCE_ANALYSIS', true),
        'case_summarization' => env('GEMMA_FEATURE_CASE_SUMMARIZATION', true),
    ],

];
