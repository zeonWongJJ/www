package app.vdao.qidu.wxapi;

import android.app.Activity;
import android.content.Intent;
import android.os.Bundle;
import android.os.Parcel;
import android.os.Parcelable;
import android.widget.Toast;

import com.google.gson.Gson;
import com.gzqx.common.httpbase.net.WXLoginService;
import com.gzqx.common.utils.DataUtils;
import com.gzqx.common.utils.IntentParams;
import com.tencent.mm.opensdk.constants.ConstantsAPI;
import com.tencent.mm.opensdk.modelbase.BaseReq;
import com.tencent.mm.opensdk.modelbase.BaseResp;
import com.tencent.mm.opensdk.modelmsg.SendAuth;
import com.tencent.mm.opensdk.modelmsg.SendMessageToWX;
import com.tencent.mm.opensdk.modelmsg.WXMediaMessage;
import com.tencent.mm.opensdk.modelmsg.WXTextObject;
import com.tencent.mm.opensdk.openapi.IWXAPI;
import com.tencent.mm.opensdk.openapi.IWXAPIEventHandler;
import com.tencent.mm.opensdk.openapi.WXAPIFactory;

import app.vdao.qidu.R;

import java.io.IOException;

import app.vdao.qidu.bean.Auth;
import okhttp3.ResponseBody;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;


public class WXEntryActivity extends Activity implements IWXAPIEventHandler {
	
	private static final int TIMELINE_SUPPORTED_VERSION = 0x21020001;

	
	// IWXAPI 是第三方app和微信通信的openapi接口
    private IWXAPI msgApi;
	
    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        //setContentView(R.layout.entry);

		msgApi = WXAPIFactory.createWXAPI(this, null);
// 将该app注册到微信
		msgApi.registerApp(DataUtils.WECHAT_APP_ID);
        // 通过WXAPIFactory工厂，获取IWXAPI的实例


		msgApi.handleIntent(getIntent(), this);
    }

	@Override
	protected void onNewIntent(Intent intent) {
		super.onNewIntent(intent);
		
		setIntent(intent);
		msgApi.handleIntent(intent, this);
	}



	// 微信发送请求到第三方应用时，会回调到该方法
	@Override
	public void onReq(BaseReq req) {
		//Toast.makeText(this, "openid = " + req.openId, Toast.LENGTH_SHORT).show();
		
		switch (req.getType()) {
		case ConstantsAPI.COMMAND_GETMESSAGE_FROM_WX:
			//goToGetMsg();
			break;
		case ConstantsAPI.COMMAND_SHOWMESSAGE_FROM_WX:
			//goToShowMsg((ShowMessageFromWX.Req) req);
			break;
		case ConstantsAPI.COMMAND_LAUNCH_BY_WX:
			//Toast.makeText(this, R.string.launch_from_wx, Toast.LENGTH_SHORT).show();
			break;
		default:
			break;
		}
	}

	// 第三方应用发送到微信的请求处理后的响应结果，会回调到该方法
	@Override
	public void onResp(BaseResp baseResp) {
		//Toast.makeText(this, "openid = " + baseResp.openId, Toast.LENGTH_SHORT).show();
		if (baseResp.getType() == ConstantsAPI.COMMAND_SENDAUTH) {//授权code成功
			onRespAuth(baseResp);//拿到了微信返回的code,立马再去请求access_token
		} else if (baseResp.getType() == ConstantsAPI.COMMAND_SENDMESSAGE_TO_WX) {//微信分享成功
			onRespSend(baseResp);
		} else{
			sendAuthData(null);
			finish();
		}

		/*Log.i("aaaa","开放id--->"+resp.openId);
		test(resp.openId);
		if (resp.getType() == ConstantsAPI.COMMAND_SENDAUTH) {
			//Toast.makeText(this, "code = " + ((SendAuth.Resp) resp).code, Toast.LENGTH_SHORT).show();
		}
		
		int result = 0;
		
		switch (resp.errCode) {
		case BaseResp.ErrCode.ERR_OK:
			//result = R.string.errcode_success;
			break;
		case BaseResp.ErrCode.ERR_USER_CANCEL:
			//result = R.string.errcode_cancel;
			break;
		case BaseResp.ErrCode.ERR_AUTH_DENIED:
			//result = R.string.errcode_deny;
			break;
		default:
			//result = R.string.errcode_unknown;
			break;
		}*/
		
		//Toast.makeText(this, result, Toast.LENGTH_LONG).show();
	}

	private  void getAccessTokenByCode(String code) {
		Retrofit retrofit = new Retrofit.Builder()
				.baseUrl("https://api.weixin.qq.com/")
				.addConverterFactory(GsonConverterFactory.create())
				.build();
		WXLoginService apiService = retrofit.create(WXLoginService.class);

		Call<ResponseBody> call = apiService.getAccessTokenData(DataUtils.WECHAT_APP_ID,DataUtils.WECHAT_SECRET_ID,code, "authorization_code");
		call.enqueue(new Callback<ResponseBody>() {
			@Override
			public void onResponse(Call<ResponseBody> call, Response<ResponseBody> response) {
				if (response.isSuccessful()) {
					// do SomeThing
					Gson gson=new Gson();
					try {
						Auth auth = gson.fromJson(response.body().string(), Auth.class);
						getUserData(auth.access_token, auth.openid);
					} catch (IOException e) {
						e.printStackTrace();
					}
				} else {
					//直接操作UI 返回的respone被直接解析成你指定的modle
				}
			}

			@Override
			public void onFailure(Call<ResponseBody> call, Throwable t) {

				// do onFailure代码
			}
		});
	}

	private  void getUserData(String accessToken, String openId) {
		Retrofit retrofit = new Retrofit.Builder()
				.baseUrl("https://api.weixin.qq.com/")
				.addConverterFactory(GsonConverterFactory.create())
				.build();
		WXLoginService apiService = retrofit.create(WXLoginService.class);
		Call<ResponseBody> call = apiService.getUserData(accessToken,openId);
		call.enqueue(new Callback<ResponseBody>() {
			@Override
			public void onResponse(Call<ResponseBody> call, Response<ResponseBody> response) {
				if (response.isSuccessful()) {
					// do SomeThing
					try {
						String str=response.body().string();
						Intent intent=new Intent();
						intent.setAction(IntentParams.ACTION_GET_USER_INFO_BY_WX_LOGIN);
						intent.putExtra(IntentParams.KEY_USER_INFO_BY_WX_LOGIN,str);
						sendBroadcast(intent);
						finish();
					} catch (IOException e) {
						e.printStackTrace();
					}
				} else {
					//直接操作UI 返回的respone被直接解析成你指定的modle
				}
			}

			@Override
			public void onFailure(Call<ResponseBody> call, Throwable t) {

				// do onFailure代码
			}
		});
	}

	private void test(String openId){
		String text="这是一个演习";
		// 初始化一个WXTextObject对象
		WXTextObject textObj = new WXTextObject();
		textObj.text = text;

		// 用WXTextObject对象初始化一个WXMediaMessage对象
		WXMediaMessage msg = new WXMediaMessage();
		msg.mediaObject = textObj;
		// 发送文本类型的消息时，title字段不起作用
		// msg.title = "Will be ignored";
		msg.description = text;

		// 构造一个Req
		SendMessageToWX.Req req = new SendMessageToWX.Req();
		req.transaction = buildTransaction("text"); // transaction字段用于唯一标识一个请求
		req.message = msg;
		req.scene = SendMessageToWX.Req.WXSceneTimeline ;
		req.openId = openId;
		// 调用api接口发送数据到微信
		msgApi.sendReq(req);
		finish();
	}
	private String buildTransaction(final String type) {
		return (type == null) ? String.valueOf(System.currentTimeMillis()) : type + System.currentTimeMillis();
	}
	private void onRespSend(BaseResp baseResp) {
		finish();
	}
	// supported during Build.OPENID_SUPPORTED_SDK_INT = 0x22000001
	private void onRespAuth(BaseResp baseResp) {
		SendAuth.Resp resultResp= (SendAuth.Resp) baseResp;

		//String resultStr = "{code:" + resultResp.code + ",state:" + resultResp.state + ",errCode:" + resultResp.errCode + ",type:" + resultResp.getType()+"}" ;
		//Log.i("hhhhh",resultStr);
//        JSONObject resultObj = null;
//        try {
//            resultObj = new JSONObject(str);
//        } catch (JSONException e) {
//            e.printStackTrace();
//
//        }
        /*Intent resultIntent = new Intent(CommonStatic.ACTION_JMT_BIND_ACCOUNT);
        resultIntent.putExtra(CommonStatic.ACCOUNT_AUTH_RESULT, resultStr);
        sendBroadcast(resultIntent);
        finish();*/

		switch (baseResp.errCode) {
			case BaseResp.ErrCode.ERR_OK:
				String code = ((SendAuth.Resp) baseResp).code;
				//Toast.makeText(this, "code = " + code, Toast.LENGTH_SHORT).show();
				getAccessTokenByCode(code);
				break;
			default:
				//sendAuthData(null);
				Toast.makeText(WXEntryActivity.this, "授权失败", Toast.LENGTH_SHORT).show();
				finish();
				break;
		}
	}


	private void sendAuthData(Auth auth) {
		/*Intent intent = new Intent();
		if (auth != null) {
			intent.setAction(ACTION_LOGIN_SUCCESS);
			intent.putExtra(KEY_AUTH_DATA, auth);
		} else {
			intent.setAction(ACTION_LOGIN_FAILURE);
		}
		sendBroadcast(intent);*/
	}



}