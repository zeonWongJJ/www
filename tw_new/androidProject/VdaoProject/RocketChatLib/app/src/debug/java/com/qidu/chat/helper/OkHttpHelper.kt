package com.qidu.chat.helper

//object OkHttpHelper {
//
//    fun getClient(): OkHttpClient {
//        if (httpClient == null) {
//            httpClient = OkHttpClient()
//        }
//        return httpClient ?: throw AssertionError("httpClient set to null by another thread")
//    }
//
//    fun getClientForUploadFile(): OkHttpClient {
//        if (httpClientForUploadFile == null) {
//            httpClientForUploadFile = OkHttpClient.Builder().build()
//        }
//        return httpClientForUploadFile ?: throw AssertionError("httpClientForUploadFile set to null by another thread")
//    }
//
//    fun getClientForDownloadFile(context: Context): OkHttpClient {
//        if(httpClientForDownloadFile == null) {
//            httpClientForDownloadFile = OkHttpClient.Builder()
//                    .addNetworkInterceptor(StethoInterceptor())
//                    .followRedirects(true)
//                    .followSslRedirects(true)
//                    .addInterceptor(CookieInterceptor(DefaultCookieProvider(RocketChatCache(context))))
//                    .build()
//        }
//        return httpClientForDownloadFile ?: throw  AssertionError("httpClientForDownloadFile set to null by another thread")
//    }
//    /**
//     * Returns the OkHttpClient instance for WebSocket connection.
//     * @return The OkHttpClient WebSocket connection instance.
//     */
//    fun getClientForWebSocket(): OkHttpClient {
//        if (httpClientForWS == null) {
//            httpClientForWS = OkHttpClient.Builder()
//                    .readTimeout(0, TimeUnit.NANOSECONDS)
//                    .build()
//        }
//        return httpClientForWS ?: throw AssertionError("httpClientForWS set to null by another thread")
//    }
//
//    private var httpClient: OkHttpClient? = null
//    private var httpClientForUploadFile: OkHttpClient? = null
//    private var httpClientForDownloadFile: OkHttpClient? = null
//    private var httpClientForWS: OkHttpClient? = null
//}
/**
     * Returns the OkHttpClient instance for WebSocket connection.
     * @return The OkHttpClient WebSocket connection instance.
     *//*

    fun getClientForWebSocket(): OkHttpClient {
        if (httpClientForWS == null) {
            httpClientForWS = OkHttpClient.Builder()
                    .readTimeout(0, TimeUnit.NANOSECONDS)
                    .build()
        }
        return httpClientForWS ?: throw AssertionError("httpClientForWS set to null by another thread")
    }

    private var httpClient: OkHttpClient? = null
    private var httpClientForUploadFile: OkHttpClient? = null
    private var httpClientForDownloadFile: OkHttpClient? = null
    private var httpClientForWS: OkHttpClient? = null
}*/
