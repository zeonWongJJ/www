package com.printer.receipt;

import android.annotation.SuppressLint;
import android.app.AlertDialog;
import android.app.AlertDialog.Builder;
import android.app.ProgressDialog;
import android.content.BroadcastReceiver;
import android.content.ComponentName;
import android.content.Context;
import android.content.DialogInterface;
import android.content.DialogInterface.OnCancelListener;
import android.content.DialogInterface.OnClickListener;
import android.content.Intent;
import android.content.IntentFilter;
import android.content.ServiceConnection;
import android.content.pm.PackageInfo;
import android.content.pm.PackageManager;
import android.content.pm.PackageManager.NameNotFoundException;
import android.hardware.usb.UsbManager;
import android.net.Uri;
import android.os.Bundle;
import android.os.Environment;
import android.os.Handler;
import android.os.IBinder;
import android.os.Message;
import android.text.TextUtils;
import android.util.Log;
import android.view.View;
import android.widget.AdapterView;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.Toast;

import com.printer.receipt.bean.Goods;
import com.printer.receipt.global.GlobalContants;
import com.printer.receipt.utils.CommonKey;
import com.printer.receipt.utils.IntentParams;
import com.printer.receipt.utils.SharedPreferencesUtils;
import com.printer.receipt.utils.TimeUtil;
import com.printer.receipt.utils.XTUtils;
import com.printer.receipt.webview.MainCordovaActivity;
import com.printer.sdk.PrinterInstance;
import com.printer.sdk.usb.USBPort;

import net.posprinter.posprinterface.IMyBinder;
import net.posprinter.posprinterface.ProcessData;
import net.posprinter.posprinterface.UiExecute;
import net.posprinter.service.PosprinterService;
import net.posprinter.utils.DataForSendToPrinterTSC;
import net.posprinter.utils.PosPrinterDev;
import net.tsz.afinal.FinalHttp;
import net.tsz.afinal.http.AjaxCallBack;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.File;
import java.io.IOException;
import java.io.InputStream;
import java.net.HttpURLConnection;
import java.net.MalformedURLException;
import java.net.URL;
import java.text.ParseException;
import java.util.ArrayList;
import java.util.List;

import cashier.vdao.app.R;

public abstract class HomeActivity extends MainCordovaActivity{
	//热敏干胶机相关
	IMyBinder binder;//IMyBinder接口，所有可供调用的连接和发送数据的方法都封装在这个接口内
	//bindService的参数conn
	ServiceConnection conn=new ServiceConnection() {

		@Override
		public void onServiceDisconnected(ComponentName name) {
			// TODO Auto-generated method stub
			//
			//binder=null;

		}

		@Override
		public void onServiceConnected(ComponentName name, IBinder service) {
			// TODO Auto-generated method stub
			//绑定成功
			binder=(IMyBinder) service;

		}
	};
	boolean isConnect;//用来标识连接状态的一个boolean值
	private List<String> usbList;
	PosPrinterDev posdev;
	//private View dialogView3;
	public  String usbDev="";
	//private ArrayAdapter<String> adapter3;
	//private HotPaperAdapter adapter3;
	//小票机相关
	private static final String TAG = "MainActivity";

	private LinearLayout header;
	private static Context mContext;
	private String apkurl;
	private String description;
	private ProgressDialog dialog;



	@SuppressLint("InlinedApi")
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		/*setContentView(getContentLayoutId());*/
		//绑定service，获取ImyBinder对象
		Intent intent=new Intent(this,PosprinterService.class);
		bindService(intent, conn, BIND_AUTO_CREATE);

		mContext = getApplicationContext();
		IntentFilter filter = new IntentFilter();
		filter.addAction(UsbManager.ACTION_USB_DEVICE_ATTACHED);
		filter.addAction(UsbManager.ACTION_USB_DEVICE_DETACHED);
		mContext.registerReceiver(mUsbAttachReceiver, filter);

		dialog = new ProgressDialog(this);
		dialog.setProgressStyle(ProgressDialog.STYLE_HORIZONTAL);
		dialog.setCancelable(false);
		//app版本升级
		checkUpdate();
		// TODO
		// fu = new FileUtils();
		// fu.createFile(this);// 向SD卡上写入打印文件
	}


	private String type;//type
	//热敏干胶机打印 打印文本，直线，条码
	public void printContextLineBarCodeByThermosensitiveDryGlueMachine(String type){
		this.type=null;
		this.type=type;
		if(usbDev.isEmpty()){
			setUsb();
		}else {
			connectUSB(usbDev);
		}
	}

	/*private int seriesNumber;
	private void setSeriesNumber(){
		//设置序列号相关---------------------------------------------------------------------------------
		seriesNumber = 100;//序列号
		String lastDate=(String) SharedPreferencesUtils.getInstance(getActivity()).getData(CommonKey.LAST_TIME_HOT_MACHINE,"");
		if(!TextUtils.isEmpty(lastDate)){
			try {
				if(!TimeUtil.IsToday(lastDate)){//lastDate不是今天就更新为今天，并且seriesNumber重新初始化为100
					SharedPreferencesUtils.getInstance(getActivity()).saveData(CommonKey.LAST_TIME_HOT_MACHINE,TimeUtil.currentTimeFormat());
					SharedPreferencesUtils.getInstance(getActivity()).saveData(CommonKey.LAST_SERIES_NUMBER_HOT_MACHINE,100);
				}
				seriesNumber=(Integer) SharedPreferencesUtils.getInstance(getActivity()).getData(CommonKey.LAST_SERIES_NUMBER_HOT_MACHINE,100);
				seriesNumber=seriesNumber+1;
				SharedPreferencesUtils.getInstance(getActivity()).saveData(CommonKey.LAST_SERIES_NUMBER_HOT_MACHINE,seriesNumber);
			} catch (ParseException e) {
				e.printStackTrace();
			}
		}else {
			SharedPreferencesUtils.getInstance(getActivity()).saveData(CommonKey.LAST_TIME_HOT_MACHINE,TimeUtil.currentTimeFormat());
			seriesNumber=seriesNumber+1;
			SharedPreferencesUtils.getInstance(getActivity()).saveData(CommonKey.LAST_SERIES_NUMBER_HOT_MACHINE,seriesNumber);
		}
		//----------------------------------------------------------------------------------------------------
	}*/
	//热敏干胶机打印 纯文本标签
	private List<Goods> coffeeNameList;
	public void printContextByThermosensitiveDryGlueMachine(String type,JSONObject object){
		coffeeNameList=new ArrayList<Goods>();
		String seriesNumber="";
		if(object.has("series_number")){
			try {
				seriesNumber=object.getString("series_number");
			} catch (JSONException e) {
				e.printStackTrace();
			}
		}
		try {
			JSONArray array=object.getJSONArray("cart");
			for(int i=0;i<array.length();i++){
				JSONObject jsonObject= (JSONObject) array.get(i);
				String productName=jsonObject.getString("product_name");
				String cup_name= null;
				try {
					if(jsonObject.has("cup_name")) {
						cup_name = jsonObject.getString("cup_name");
					}
				} catch (JSONException e) {
					e.printStackTrace();
				}
				String strNum=jsonObject.getString("num");
				int num=Integer.parseInt(strNum);
				//int num=jsonObject.getInt("num");
				String attr=null;
				try {
					if(jsonObject.has("attr")){
                        attr=jsonObject.getString("attr");
                    }
				} catch (JSONException e) {
					e.printStackTrace();
				}


				for(int k=0;k<num;k++){
					Goods goods=new Goods();
					goods.setAttr(attr);
					goods.setCup_name(cup_name);
					goods.setProduct_name(productName);
					goods.setSeries_number(seriesNumber);
					coffeeNameList.add(goods);
				}
			}
		} catch (JSONException e) {
			e.printStackTrace();
		}
		this.type=type;
		//Toast.makeText(getActivity(),"个数"+coffeeNameList.size(),Toast.LENGTH_SHORT).show();
		printCoffeeNameList(coffeeNameList);
	}

	private void printCoffeeNameList(List<Goods> coffeeNameList){
		if(coffeeNameList==null){
			return;
		}
		if(coffeeNameList.size()==0){
			return;
		}
		if(usbDev.isEmpty()){
			setUsb();
		}else {
			connectUSB(usbDev);
		}
	}
	//热敏干胶机打印条码
	public void printBarcodeByThermosensitiveDryGlueMachine(String type){
		this.type=null;
		this.type=type;
		if(usbDev.isEmpty()){
			setUsb();
		}else {
			connectUSB(usbDev);
		}
	}
	private Handler handler = new Handler() {

		@Override
		public void handleMessage(Message msg) {
			// TODO Auto-generated method stub
			super.handleMessage(msg);
			switch (msg.what) {
			case GlobalContants.SHOW_UPDATE_DIALOG:// 显示升级的对话框
				Log.i(TAG, "显示升级的对话框");
				showUpdateDialog();
				break;
			case GlobalContants.ENTER_HOME:// 进入主页面
				//enterHome();
				break;

			case GlobalContants.URL_ERROR:// URL错误
				//enterHome();
				Toast.makeText(getApplicationContext(), "URL错误", Toast.LENGTH_LONG).show();

				break;

			case GlobalContants.NETWORK_ERROR:// 网络异常
				//enterHome();
				Toast.makeText(HomeActivity.this, "网络异常", Toast.LENGTH_LONG).show();
				break;

			case GlobalContants.JSON_ERROR:// JSON解析出错
				//enterHome();
				Toast.makeText(HomeActivity.this, "JSON解析出错", Toast.LENGTH_LONG).show();
				break;
			case GlobalContants.PROGRESS_UPDATE://更新进度
				dialog.setMax(msg.arg1 / 1024);
				dialog.setProgress(msg.arg2 / 1024);
				break;
			case GlobalContants.FINISH_UPDATE://更新完成
				dialog.dismiss();
				break;
			case GlobalContants.START_UPDATE://开始更新
				dialog.setProgress(0);
				dialog.setTitle("正在下载，请稍后...");
				dialog.show();

				break;

			default:
				break;
			}
		}

	};

	@Override
	protected void onStart() {
		super.onStart();
	}

	private  BroadcastReceiver mUsbAttachReceiver = new BroadcastReceiver() {
		@SuppressLint("NewApi")
		public void onReceive(Context context, Intent intent) {
			String action = intent.getAction();
			Log.w("fdh", "receiver action: " + action);

			if (UsbManager.ACTION_USB_DEVICE_ATTACHED.equals(action)) {
				Toast.makeText(mContext, "USB设备已接入", Toast.LENGTH_SHORT).show();
			} else if (UsbManager.ACTION_USB_DEVICE_DETACHED.equals(action)) {
				Toast.makeText(mContext, "USB设备已拔出", Toast.LENGTH_SHORT).show();
				if (PrinterInstance.mPrinter != null
						&& CashHomeActivity.isConnected) {
					PrinterInstance.mPrinter.closeConnection();
					PrinterInstance.mPrinter = null;
				}
				//热敏不干胶机
				//app打开的时候，中途关闭热敏不干胶机再重新打开需要设置usbDev为空
				usbDev="";

			}
		}
	};


	@Override
	public void onDestroy() {
		super.onDestroy();
		mContext.unregisterReceiver(mUsbAttachReceiver);
		if(binder!=null){
			binder.disconnectCurrentPort(new UiExecute() {

				@Override
				public void onsucess() {

				}

				@Override
				public void onfailed() {

				}
			});
		}
		unbindService(conn);
	}

	// @Override
	// protected void onStart() {
	// super.onStart();
	// initHeader();
	// }
	//
	protected void printContextLineBarCode(){
		if (isConnect) {
			// TODO Auto-generated method stub
			//向打印机发生打印指令和打印数据，调用此方法
			//第一个参数，还是UiExecute接口的实现，分别是发生数据成功和失败后在ui线程的处理
			binder.writeDataByYouself(new UiExecute() {

				@Override
				public void onsucess() {
					// TODO Auto-generated method stub
					Toast.makeText(getApplicationContext(), getString(R.string.send_success),Toast.LENGTH_SHORT)
							.show();
				}

				@Override
				public void onfailed() {
					// TODO Auto-generated method stub
					Toast.makeText(getApplicationContext(), getString(R.string.send_failed),Toast.LENGTH_SHORT)
							.show();
				}
			}, new ProcessData() {//第二个参数是ProcessData接口的实现
				//这个接口的重写processDataBeforeSend这个处理你要发送的指令

				@Override
				public List<byte[]> processDataBeforeSend() {
					// TODO Auto-generated method stub
					//初始化一个list
					ArrayList<byte[]> list = new ArrayList<byte[]>();
					//在打印请可以先设置打印内容的字符编码类型，默认为gbk，请选择打印机可识别的类型，参看编程手册，打印代码页
					DataForSendToPrinterTSC.setCharsetName("gbk");//不设置，默认为gbk
					//通过工具类得到一个指令的byte[]数据,以文本为例
					//首先得设置size标签尺寸,宽60mm,高30mm,也可以调用以dot或inch为单位的方法具体换算参考编程手册
					byte[] data0 = DataForSendToPrinterTSC
							.sizeBymm(60, 30);
					list.add(data0);
					//设置Gap,同上
					list.add(DataForSendToPrinterTSC.gapBymm(0,
							0));

					//清除缓存
					list.add(DataForSendToPrinterTSC.cls());
					//条码指令，参数：int x，x方向打印起始点；int y，y方向打印起始点；
					//string font，字体类型；int rotation，旋转角度；
					//int x_multiplication，字体x方向放大倍数
					//int y_multiplication,y方向放大倍数
					//string content，打印内容
					byte[] data1 = DataForSendToPrinterTSC
							.text(10, 10, "0", 0, 1, 1,
									"abc123");
					list.add(data1);
					//打印直线,int x;int y;int width,线的宽度，int height,线的高度
					list.add(DataForSendToPrinterTSC.bar(20,
							40, 200, 3));
					//打印条码
					list.add(DataForSendToPrinterTSC.barCode(
							60, 50, "128", 100, 1, 0, 2, 2,
							"abcdef12345"));
					//打印
					list.add(DataForSendToPrinterTSC.print(1));
					return list;
				}
			});
		}else {
			Toast.makeText(getApplicationContext(), getString(R.string.not_con_printer), Toast.LENGTH_SHORT).show();
		}
	}

	//单独打印文本--热敏干胶机器
	protected void printTextByThermosensitiveDryGlueMachine(final Goods goods){




		//此处用binder里的另外一个发生数据的方法,同样，也要按照编程手册上的示例一样，先设置标签大小
		//如果数据处理较为复杂，请勿选择此方法
		//上面的发送方法的数据处理是在工作线程中完成的，不会阻塞UI线程
		byte[] data0= DataForSendToPrinterTSC.sizeBydot(480, 240);
		byte[] data1=DataForSendToPrinterTSC.cls();

		//DataForSendToPrinterTSC.setCharsetName("utf-8");//不设置，默认为gbk
		/*byte[] data2=DataForSendToPrinterTSC.text(100, 100, "TSS24.BF2", 0, 2, 2,content);//参数font为 TSS24.BF2 简体中文 0时默认打印数字字母 xmultiplication x方向放大倍数
		byte[] data3=DataForSendToPrinterTSC.print(1);
		byte[] data=byteMerger(byteMerger(byteMerger(data0, data1), data2), data3);*/

		//产品名称 一行最多六个字
		final String product_name=goods.getProduct_name();
		byte[] data ;
		if(product_name.length()>6){
			String seriesRow="序列号:"+goods.getSeries_number();
			String firstRow=product_name.substring(0,6);
			String twoRow=product_name.substring(6,product_name.length());
			byte[] dataSeries=DataForSendToPrinterTSC.text(100, 20, "TSS24.BF2", 0, 1, 1,seriesRow);
			byte[] dataFirstRow=DataForSendToPrinterTSC.text(100, 45, "TSS24.BF2", 0, 2, 2,firstRow);
			byte[] dataTwoRow=DataForSendToPrinterTSC.text(100, 100, "TSS24.BF2", 0, 2, 2,twoRow);
			String strAttr = null;
			String cup_name=goods.getCup_name();
			if(cup_name!=null){
				strAttr=cup_name;
			}
			String attr=goods.getAttr();
			if(attr!=null){
				try {
					JSONArray jsonArray=new JSONArray(attr);
					for(int i=0;i<jsonArray.length();i++){
						JSONObject object=jsonArray.getJSONObject(i);
						String attr_name=object.getString("attr_name");
						strAttr=strAttr+" "+attr_name;
					}
				} catch (JSONException e) {
					e.printStackTrace();
				}
			}
			if(!TextUtils.isEmpty(strAttr)){
				if(strAttr.length()>14){
					String threeRow=strAttr.substring(0,14);
					String fourRow=strAttr.substring(14,strAttr.length());
					byte[] dataThreeRow=DataForSendToPrinterTSC.text(100, 160, "TSS24.BF2", 0, 1, 1,threeRow);
					byte[] dataFourRow=DataForSendToPrinterTSC.text(100, 185, "TSS24.BF2", 0, 1, 1,fourRow);
					//data=byteMerger(byteMerger(byteMerger(byteMerger(byteMerger(data0, data1), dataFirstRow), dataTwoRow),dataThreeRow),dataFourRow);
					byte[] data5=DataForSendToPrinterTSC.print(1);

					//data=byteMerger(byteMerger(byteMerger(byteMerger(byteMerger(byteMerger(data0, data1), dataFirstRow), dataTwoRow),dataThreeRow),dataFourRow), data5);
					//byteMerger(byteMerger(data0, data1),dataSeries);
					data=byteMerger(byteMerger(byteMerger(byteMerger(byteMerger(byteMerger(byteMerger(data0, data1),dataSeries), dataFirstRow), dataTwoRow),dataThreeRow),dataFourRow), data5);
				}else {
					byte[] dataThreeRow=DataForSendToPrinterTSC.text(100, 170, "TSS24.BF2", 0, 1, 1,strAttr);
					//data=byteMerger(byteMerger(byteMerger(byteMerger(data0, data1), dataFirstRow), dataTwoRow),dataThreeRow);
					byte[] data5=DataForSendToPrinterTSC.print(1);
					//data=byteMerger(byteMerger(byteMerger(byteMerger(byteMerger(data0, data1), dataFirstRow), dataTwoRow),dataThreeRow),data5);
					data=byteMerger(byteMerger(byteMerger(byteMerger(byteMerger(byteMerger(data0, data1),dataSeries), dataFirstRow), dataTwoRow),dataThreeRow),data5);
				}
			}else {
				byte[] data5=DataForSendToPrinterTSC.print(1);
				//data=byteMerger(byteMerger(byteMerger(data0, data1), dataFirstRow), dataTwoRow);
				//data=byteMerger(byteMerger(byteMerger(byteMerger(data0, data1), dataFirstRow), dataTwoRow),data5);
				data=byteMerger(byteMerger(byteMerger(byteMerger(byteMerger(data0, data1),dataSeries), dataFirstRow), dataTwoRow),data5);
			}

		}else {
			String seriesRow="序列号:"+goods.getSeries_number();
			byte[] dataSeries=DataForSendToPrinterTSC.text(100, 25, "TSS24.BF2", 0, 1, 1,seriesRow);
			byte[] dataFirstRow=DataForSendToPrinterTSC.text(100, 60, "TSS24.BF2", 0, 2, 2,product_name);
			String strAttr = null;
			String cup_name=goods.getCup_name();
			if(cup_name!=null){
				strAttr=cup_name;
			}
			String attr=goods.getAttr();
			if(attr!=null){
				try {
					JSONArray jsonArray=new JSONArray(attr);
					for(int i=0;i<jsonArray.length();i++){
						JSONObject object=jsonArray.getJSONObject(i);
						String attr_name=object.getString("attr_name");
						strAttr=strAttr+" "+attr_name;
					}
				} catch (JSONException e) {
					e.printStackTrace();
				}
			}
			if(!TextUtils.isEmpty(strAttr)){
				if(strAttr.length()>14){
					String threeRow=strAttr.substring(0,14);
					String fourRow=strAttr.substring(14,strAttr.length());
					byte[] dataTwoRow=DataForSendToPrinterTSC.text(100, 120, "TSS24.BF2", 0, 1, 1,threeRow);
					byte[] dataThreeRow=DataForSendToPrinterTSC.text(100, 160, "TSS24.BF2", 0, 1, 1,fourRow);
					//data=byteMerger(byteMerger(byteMerger(byteMerger(data0, data1), dataFirstRow), dataTwoRow),dataThreeRow);
					byte[] data5=DataForSendToPrinterTSC.print(1);
					//data=byteMerger(byteMerger(byteMerger(byteMerger(byteMerger(data0, data1), dataFirstRow), dataTwoRow),dataThreeRow),data5);

					data=byteMerger(byteMerger(byteMerger(byteMerger(byteMerger(byteMerger(data0, data1),dataSeries), dataFirstRow), dataTwoRow),dataThreeRow),data5);
				}else {
					byte[] dataTwoRow=DataForSendToPrinterTSC.text(100, 130, "TSS24.BF2", 0, 1, 1,strAttr);
					//data=byteMerger(byteMerger(byteMerger(data0, data1), dataFirstRow), dataTwoRow);
					byte[] data5=DataForSendToPrinterTSC.print(1);
					//data=byteMerger(byteMerger(byteMerger(byteMerger(data0, data1), dataFirstRow), dataTwoRow),data5);
					data=byteMerger(byteMerger(byteMerger(byteMerger(byteMerger(data0, data1),dataSeries), dataFirstRow), dataTwoRow),data5);
				}
			}else {
				byte[] data5=DataForSendToPrinterTSC.print(1);
				//data=byteMerger(byteMerger(data0, data1), dataFirstRow);
				//data=byteMerger(byteMerger(byteMerger(data0, data1), dataFirstRow),data5);
				data=byteMerger(byteMerger(byteMerger(byteMerger(data0, data1),dataSeries), dataFirstRow),data5);
			}
		}
		//byte[] data5=DataForSendToPrinterTSC.print(1);
		//byte[] dataA=byteMerger(data, data5);



		/*byte[] data2=DataForSendToPrinterTSC.text(100, 50, "TSS24.BF2", 0, 2, 2,product_name);//参数font为 TSS24.BF2 简体中文 0时默认打印数字字母
		byte[] data4=DataForSendToPrinterTSC.text(100, 110, "TSS24.BF2", 0, 2, 2,"咖啡");//参数font为 TSS24.BF2 简体中文 0时默认打印数字字母
		byte[] data5=DataForSendToPrinterTSC.text(100, 180, "TSS24.BF2", 0, 1, 1,"大杯 加热 酸的 甜的 炸的 辣的");
		byte[] data6=DataForSendToPrinterTSC.print(1);
		//byte[] data=byteMerger(byteMerger(byteMerger(data0, data1), data2), data3);
		byte[] data=byteMerger(byteMerger(byteMerger(byteMerger(byteMerger(data0, data1), data2), data4),data5),data6);*/
		if (isConnect) {
			binder.write(data, new UiExecute() {
				@Override
				public void onsucess() {
					// TODO Auto-generated method stub
					/*Toast.makeText(getApplicationContext(), getString(R.string.send_success), Toast.LENGTH_SHORT)
							.show();*/
					if(coffeeNameList!=null) {
						if (coffeeNameList.size() > 0) {
							for (int i = 0; i < coffeeNameList.size(); i++) {
								//“==”比较的是引用的地址，用equals比较的就是值
								if ((coffeeNameList.get(i))==goods) {
									coffeeNameList.remove(i);
								}
							}

							if(coffeeNameList.size()>0){
								printCoffeeNameList(coffeeNameList);
							}
						}else {
							coffeeNameList=null;
						}
					}

				}

				@Override
				public void onfailed() {
					if(coffeeNameList!=null) {
						if (coffeeNameList.size() > 0) {
							printCoffeeNameList(coffeeNameList);
						}else {
							coffeeNameList=null;
						}
					}
				}
			});
		}else {
			Toast.makeText(getApplicationContext(), getString(R.string.not_con_printer), Toast.LENGTH_SHORT).show();
		}
	}

	/**
	 * byte数组拼接
	 * */
	private  byte[] byteMerger(byte[] byte_1, byte[] byte_2){
		byte[] byte_3 = new byte[byte_1.length+byte_2.length];
		System.arraycopy(byte_1, 0, byte_3, 0, byte_1.length);
		System.arraycopy(byte_2, 0, byte_3, byte_1.length, byte_2.length);
		return byte_3;
	}
	/**
	 * 检查是否有新版本，如果有就升级
	 */
	private void checkUpdate() {

		new Thread() {
			public void run() {
				// URLhttp://192.168.1.254:8080/updateinfo.html

				Message mes = Message.obtain();
				long startTime = System.currentTimeMillis();
				try {

					URL url = new URL(getString(R.string.serverurl));
					// 联网
					HttpURLConnection conn = (HttpURLConnection) url
							.openConnection();
					conn.setRequestMethod("GET");
					conn.setConnectTimeout(4000);
					int code = conn.getResponseCode();
					if (code == 200) {
						// 联网成功
						InputStream is = conn.getInputStream();
						// 把流转成String
						String result = XTUtils.readFromStream(is);
						Log.i(TAG, "联网成功了" + result);
						// json解析
						JSONObject obj = new JSONObject(result);
						// 得到服务器的版本信息
						int versionCode = obj.getInt("versionCode");

						description = (String) obj.get("description");
						apkurl = (String) obj.get("apkUrl");

						// 校验是否有新版本
						if (getVersionCode()<versionCode) {
							// 有新版本，弹出一升级对话框
							mes.what = GlobalContants.SHOW_UPDATE_DIALOG;
						} else {
							// 版本一致，没有新版本，进入主页面
							mes.what = GlobalContants.ENTER_HOME;
						}

					}

				} catch (MalformedURLException e) {
					// TODO Auto-generated catch block
					mes.what = GlobalContants.URL_ERROR;
					e.printStackTrace();
				} catch (IOException e) {
					mes.what = GlobalContants.NETWORK_ERROR;
					e.printStackTrace();
				} catch (JSONException e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
					mes.what = GlobalContants.JSON_ERROR;
				} finally {

					long endTime = System.currentTimeMillis();
					// 我们花了多少时间
					long dTime = endTime - startTime;
					// 2000
					if (dTime < 2000) {
						try {
							Thread.sleep(2000 - dTime);
						} catch (InterruptedException e) {
							// TODO Auto-generated catch block
							e.printStackTrace();
						}
					}

					handler.sendMessage(mes);
					Log.i(TAG, "mes:"+mes);
				}

			};
		}.start();

	}
	/**
	 * 得到应用程序的版本名称
	 */

	private int getVersionCode() {
		// 用来管理手机的APK
		PackageManager pm = getPackageManager();

		try {
			// 得到知道APK的功能清单文件
			PackageInfo info = pm.getPackageInfo(getPackageName(), 0);
			return info.versionCode;
		} catch (NameNotFoundException e) {
			// TODO Auto-generated catch block
			e.printStackTrace();
			return 0;
		}

	}

	/**
	 * 弹出升级对话框
	 */
	protected void showUpdateDialog() {
		//this = Activity.this
		Builder builder = new Builder(HomeActivity.this);
		builder.setTitle("提示");
		builder.setCancelable(false);//强制升级
		builder.setOnCancelListener(new OnCancelListener() {

			@Override
			public void onCancel(DialogInterface dialog) {
				// TODO Auto-generated method stub
				//进入主页面
//				enterHome();
				dialog.dismiss();

			}
		});
		builder.setMessage(description);
		builder.setPositiveButton("立刻升级", new OnClickListener() {

			@Override
			public void onClick(DialogInterface dialog, int which) {

				// 下载APK，并且替换安装
				try {
					if (Environment.getExternalStorageState().equals(
							Environment.MEDIA_MOUNTED)) {
						// sdcard存在
						// afnal
						FinalHttp finalhttp = new FinalHttp();
						finalhttp.download(apkurl, Environment
								.getExternalStorageDirectory().getAbsolutePath()+"/vdao_cashier.apk",
								new AjaxCallBack<File>() {

									@Override
									public void onFailure(Throwable t, int errorNo,
											String strMsg) {
										super.onFailure(t, errorNo, strMsg);
										t.printStackTrace();
										Toast.makeText(getApplicationContext(), "下载失败", Toast.LENGTH_LONG).show();
										handler.obtainMessage(GlobalContants.FINISH_UPDATE).sendToTarget();
									}

									@Override
									public void onLoading(long count, long current) {
										// TODO Auto-generated method stub
										super.onLoading(count, current);
//									tv_update_info.setVisibility(View.VISIBLE);
//									//当前下载百分比
//									int progress = (int) (current * 100 / count);
//									tv_update_info.setText("下载进度："+progress+"%");
//									dialog.setMax(timeout / 1000);
//									handler.obtainMessage(GlobalContants.PROGRESS_UPDATE).sendToTarget();

										handler.obtainMessage(GlobalContants.PROGRESS_UPDATE, (int)count, (int)current).sendToTarget();
										Log.i(TAG, "updating!");
									}

									@Override
									public void onSuccess(File t) {
										// TODO Auto-generated method stub
										super.onSuccess(t);
										installAPK(t);
									}

									@Override
									public void onStart() {
										super.onStart();
										Log.i(TAG, "start update!");
										handler.obtainMessage(GlobalContants.START_UPDATE).sendToTarget();
									}
									/**
									 * 安装APK
									 * @param t
									 */
									private void installAPK(File t) {
									  Intent intent = new Intent();
									  intent.setAction("android.intent.action.VIEW");
									  intent.addCategory("android.intent.category.DEFAULT");
									  intent.setDataAndType(Uri.fromFile(t), "application/vnd.android.package-archive");
									  startActivity(intent);
									  android.os.Process.killProcess(android.os.Process.myPid());
									}
								});
					} else {
						Toast.makeText(getApplicationContext(), "没有sdcard，请安装上在试",
								Toast.LENGTH_SHORT).show();
						return;
					}
				} catch (Exception e) {
					Log.i(TAG, "有异常!");
					e.printStackTrace();
				}
			}
		});
		/*builder.setNegativeButton("下次再说", new OnClickListener() {

			@Override
			public void onClick(DialogInterface dialog, int which) {
				// TODO Auto-generated method stub
				dialog.dismiss();
//				enterHome();// 进入主页面
			}
		});*/
		builder.show();

	}




	//热敏干胶机 选择连接的USB设备
	protected void setUsb() {

		/*Intent intent=new Intent(this,PosprinterService.class);
		bindService(intent, conn, BIND_AUTO_CREATE);*/
		// TODO Auto-generated method stub
		/*LayoutInflater inflater=LayoutInflater.from(this);
		View dialogView3=inflater.inflate(R.layout.usb_link, null);
		TextView tv_usb=(TextView) dialogView3.findViewById(R.id.textView1);
		ListView lv_usb=(ListView) dialogView3.findViewById(R.id.listView1);*/
		usbList=PosPrinterDev.GetUsbPathNames(this);
		if (usbList==null) {
			usbList=new ArrayList<String>();
		}
		/*tv_usb.setText(getString(R.string.usb_pre_con)+usbList.size());
		Toast.makeText(getApplicationContext(),"设备数量"+usbList.size(), Toast.LENGTH_SHORT).show();
		HotPaperAdapter adapter3=new HotPaperAdapter(this);
		lv_usb.setAdapter(adapter3);
		adapter3.refreshData(usbList);
		AlertDialog dialog=new AlertDialog.Builder(this)
				.setView(dialogView3)
				.create();
		dialog.show();
		set_lv_usb_listener(dialog);*/
		if(usbList.isEmpty()){
			Toast.makeText(this,"未搜索到可用设备",Toast.LENGTH_SHORT).show();
			return;
		}
		for(int i=0;i<usbList.size();i++){//接口固定
			if(usbList.get(i).contains("/dev/bus/usb/003")){
				//usbDev=usbList.get(0);
				usbDev=usbList.get(i);
			}
			/*if (!USBPort.isUsbPrinter(mUSBDevice)) {

			}*/
		}

		//Toast.makeText(this,""+usbList.toString(),Toast.LENGTH_SHORT).show();
		if(usbDev.isEmpty()){
			Toast.makeText(this,"未开启连接到可用热敏干胶机设备",Toast.LENGTH_SHORT).show();
			new AlertDialog.Builder(this).setTitle("提示").setMessage("请先开启连接到可用热敏干胶机设备")
					.setPositiveButton("确定", new DialogInterface.OnClickListener() {
						@SuppressLint("InlinedApi")
						@Override
						public void onClick(DialogInterface arg0, int arg1) {
							arg0.dismiss();
						}
					})/*.setNegativeButton(R.string.str_resel, new DialogInterface.OnClickListener() {
				@Override
				public void onClick(DialogInterface dialog, int which) {
					dialog.dismiss();
				}
			})*/.show();
			return;
		}
		//Toast.makeText(this,"======"+usbDev,Toast.LENGTH_SHORT).show();
		//et.setText(usbDev);
		new Thread(){
			public void run() {
				posdev=null;
				try {
					posdev=new PosPrinterDev(net.posprinter.utils.PosPrinterDev.PortType.USB, getApplicationContext(), usbDev);
					posdev.Open();
					runOnUiThread(new Runnable() {
						@Override
						public void run() {
							//打开之后进行连接
							connectUSB(usbDev);
						}
					});
				} catch (Exception e) {
					// TODO Auto-generated catch block
					e.printStackTrace();
				}
			};
		}.start();
	}
	private ListView lv_usb;
	private void set_lv_usb_listener(final AlertDialog dialog) {
		// TODO Auto-generated method stub
		lv_usb.setOnItemClickListener(new AdapterView.OnItemClickListener() {

			@Override
			public void onItemClick(AdapterView<?> arg0, View arg1, int arg2,
									long arg3) {
				// TODO Auto-generated method stub
				usbDev=usbList.get(arg2);
				//et.setText(usbDev);
				new Thread(){
					public void run() {
						posdev=null;
						try {
							posdev=new PosPrinterDev(net.posprinter.utils.PosPrinterDev.PortType.USB, getApplicationContext(), usbDev);
							posdev.Open();
							runOnUiThread(new Runnable() {
								@Override
								public void run() {
									//Toast.makeText(getApplicationContext(),"打开", Toast.LENGTH_SHORT).show();
									//打开之后进行连接
									connectUSB(usbDev);
								}
							});
						} catch (Exception e) {
							// TODO Auto-generated catch block
							e.printStackTrace();
						}
					};
				}.start();
				dialog.cancel();
				Log.i("TAG", usbDev);
			}
		});
	}
	//连接热敏干胶机
	protected void connectUSB(final String deviceName) {
		//setSeriesNumber();//初始化序列号放此处合理点，找到可连接设备再自增1
		if(binder==null){
			conn=new ServiceConnection() {
				@Override
				public void onServiceDisconnected(ComponentName name) {
					// TODO Auto-generated method stub
					//
					//binder=null;
				}

				@Override
				public void onServiceConnected(ComponentName name, IBinder service) {
					// TODO Auto-generated method stub
					//绑定成功
					binder=(IMyBinder) service;
					connectUSB(deviceName);
				}
			};
			Intent intent=new Intent(this,PosprinterService.class);
			bindService(intent, conn, BIND_AUTO_CREATE);
		}else {
			binder.connectUsbPort(getApplicationContext(), deviceName, new UiExecute() {

				@Override
				public void onsucess() {
					// TODO Auto-generated method stub
					//连接成功后在UI线程中的执行
					isConnect = true;
					//Toast.makeText(getApplicationContext(),"热敏不干胶机连接成功", Toast.LENGTH_SHORT).show();
					//btn0.setText(getString(R.string.con_success));
					//此处也可以开启读取打印机的数据
					//参数同样是一个实现的UiExecute接口对象
					//如果读的过程重出现异常，可以判断连接也发生异常，已经断开
					//这个读取的方法中，会一直在一条子线程中执行读取打印机发生的数据，
					//直到连接断开或异常才结束，并执行onfailed
					binder.acceptdatafromprinter(new UiExecute() {

						@Override
						public void onsucess() {
							//Toast.makeText(getApplicationContext(),"回调函数", Toast.LENGTH_SHORT).show();
						}

						@Override
						public void onfailed() {
							Toast.makeText(getApplicationContext(), getString(R.string.con_has_discon), Toast.LENGTH_SHORT).show();
						}
					});
					if (type == null) {
						return;
					}
					if (type.equals(IntentParams.TYPE_CONTEXT_LINE_BAR_CODE)) {
						printContextLineBarCode();
					} else if (type.equals(IntentParams.TYPE_CONTEXT_LABEL)) {
						if (coffeeNameList == null) {
							return;
						}
						if (coffeeNameList.size() > 0) {
							Goods goods = coffeeNameList.get(0);
							if(TextUtils.isEmpty(goods.getProduct_name())) {
								return;
							}
							printTextByThermosensitiveDryGlueMachine(goods);
						}
					} else if (type.equals(IntentParams.TYPE_PRINT_BAR_CODE)) {
						printBarcodeOnly();
					}
				}

				@Override
				public void onfailed() {
					// TODO Auto-generated method stub
					//连接失败后在UI线程中的执行
					isConnect = false;
					//Toast.makeText(getApplicationContext(),"热敏不干胶机连接失败",Toast.LENGTH_SHORT).show();
					//btn0.setText(gteString(R.string.con_failed));
				}
			});
		}
	}


	private void printBarcodeOnly(){
		if (isConnect) {
			// TODO Auto-generated method stub
			binder.writeDataByYouself(new UiExecute() {
				@Override
				public void onsucess() {
					// TODO Auto-generated method stub
				}

				@Override
				public void onfailed() {
					// TODO Auto-generated method stub

				}
			}, new ProcessData() {

				@Override
				public List<byte[]> processDataBeforeSend() {
					// TODO Auto-generated method stub
					//初始化一个list
					ArrayList<byte[]> list = new ArrayList<byte[]>();
					//通过工具类得到一个指令的byte[]数据,以文本为例
					//首先得设置size标签尺寸,宽60mm,高30mm,也可以调用以dot或inch为单位的方法具体换算参考编程手册
					byte[] data0 = DataForSendToPrinterTSC.sizeBymm(60,
							30);
					list.add(data0);
					//设置Gap,同上
					list.add(DataForSendToPrinterTSC.gapBymm(0, 0));
					//清除缓存
					list.add(DataForSendToPrinterTSC.cls());
					//打印条码
					list.add(DataForSendToPrinterTSC.barCode(60, 50,
							"128", 100, 1, 0, 2, 2, "abcdef12345"));
					//打印
					list.add(DataForSendToPrinterTSC.print(1));
					return list;
				}
			});
		}else {
			Toast.makeText(getApplicationContext(), getString(R.string.not_con_printer), Toast.LENGTH_SHORT).show();
		}
	}

}
