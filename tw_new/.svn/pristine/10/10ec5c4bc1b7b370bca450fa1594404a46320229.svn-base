package com.printer.receipt;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;

import com.printer.receipt.global.GlobalContants;
import com.printer.receipt.utils.HttpUrl;
import com.printer.receipt.utils.PrefUtils;
import com.printer.receipt.utils.XTUtils;
import com.printer.sdk.PrinterConstants.Connect;
import com.printer.sdk.PrinterInstance;
import com.printer.sdk.usb.USBPort;

import android.annotation.SuppressLint;
import android.annotation.TargetApi;
import android.app.Activity;
import android.app.AlertDialog;
import android.app.PendingIntent;
import android.app.Presentation;
import android.app.ProgressDialog;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.IntentFilter;
import android.hardware.display.DisplayManager;
import android.hardware.usb.UsbDevice;
import android.hardware.usb.UsbManager;
import android.media.MediaPlayer;
import android.os.Build;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.text.TextUtils;
import android.util.Log;
import android.view.Display;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.WindowManager;
import android.webkit.WebChromeClient;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.widget.Button;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import org.json.JSONObject;

import cashier.vdao.app.R;

@SuppressLint("HandlerLeak")
public class CashHomeActivity extends HomeActivity{
	private LinearLayout header;

	private final static int SCANNIN_GREQUEST_CODE = 2;
	public static final int CONNECT_DEVICE = 1;
	public static final int ENABLE_BT = 3;
	// 不同蓝牙链接方式的判断依据 “确认连接”
	protected static final String TAG = "CashHomeActivity";
	private static Button btn_selfprint_test;
	public static boolean isConnected = false;// 蓝牙连接状态
	public static String devicesName = "未知设备";
	private static String devicesAddress;
	private ProgressDialog dialog;
	public static PrinterInstance myPrinter;
	private static UsbDevice mUSBDevice;
	private Context mContext;
	private int interfaceType = 0;
	private List<UsbDevice> deviceList;
	private static final String ACTION_USB_PERMISSION = "com.android.usb.USB_PERMISSION";
	private TextView tv_device_name, tv_printer_address;
	private ProgressDialog dialogH;
	private DifferentDislay differentDislay;
	/*@Override
	protected int getContentLayoutId() {
		return R.layout.layout_simple_cordovaview;
	}*/

	@Override
	protected int getContentLayoutId() {
		return R.layout.activity_setting;
	}

	/**
	 * 显示扫描结果
	 */
	@Override
	protected void onCreate(Bundle savedInstanceState) {
		//getWindow().addFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN); //隐藏状态栏  如果隐藏状态栏 无法键盘无法把输入框顶上去
		showDifferentDislayScreen();
		super.onCreate(savedInstanceState);
		mContext=this;

		PrefUtils.setInt(mContext, GlobalContants.INTERFACETYPE, 1);
		interfaceType = 1;

		init();
		searchDeviceList();


		//Toast.makeText(this,getStatusBarHeight(getApplicationContext())+"===="+ NavigationBarUtil.getNavigationBarHeight(getActivity()),Toast.LENGTH_SHORT).show();
	}
	private double getStatusBarHeight(Context context){
		double statusBarHeight = Math.ceil(25 * context.getResources().getDisplayMetrics().density);
		return statusBarHeight;
	}

	private void showDifferentDislayScreen(){
		DisplayManager manager = (DisplayManager) getSystemService(Context.DISPLAY_SERVICE);
		Display[] displays = manager.getDisplays();
		// displays[0] 主屏
		// displays[1] 副屏
		//如果点击home键，辅屏依然显示内容 可以不写服务就能实现 应用摧毁它才摧毁
		differentDislay = new DifferentDislay(/*this*/getApplicationContext(),displays[1]);
		differentDislay.getWindow().setType(
				WindowManager.LayoutParams.TYPE_SYSTEM_ALERT);
		differentDislay.show();
	}
	public void loadViceScreenPageByUrl(final String url){

		if(differentDislay!=null){
			if(!TextUtils.isEmpty(url)){
				if(differentDislay.getWebView()!=null){
					//Toast.makeText(getActivity(),"副屏地址"+url,Toast.LENGTH_SHORT).show();
					differentDislay.getWebView().loadUrl(url);
				}
			}
		}
	}


	public class DifferentDislay extends Presentation {
		private WebView webView;
		public DifferentDislay(Context outerContext, Display display) {
			super(outerContext,display);
		}
		@Override
		protected void onCreate(Bundle savedInstanceState) {
			super.onCreate(savedInstanceState);
			setContentView(R.layout.activity_send_screen);
			webView= (WebView) this.findViewById(R.id.web_view);
			WebSettings webSettings = webView.getSettings();
			webSettings.setCacheMode(WebSettings.LOAD_NO_CACHE);   // 默认不使用缓存
			webSettings.setJavaScriptEnabled(true);
			//webSettings.setJavaScriptCanOpenWindowsAutomatically(true);
			//webSettings.setAllowFileAccess(true);// 设置允许访问文件数据
			webSettings.setSupportZoom(false);
			webSettings.setBuiltInZoomControls(false);
			webView.setVerticalScrollBarEnabled(false);
			webView.setHorizontalFadingEdgeEnabled(false);
			/*webView.setScrollContainer(false);
			webView.setOnTouchListener(new View.OnTouchListener() {
				@Override
				public boolean onTouch(View v, MotionEvent event) {
					return (event.getAction() == MotionEvent.ACTION_MOVE);
				}
			});*/
			//webSettings.setDomStorageEnabled(true);
			//webSettings.setDatabaseEnabled(true);
			webView.setWebViewClient(new WebViewClient(){
				@Override
				public boolean shouldOverrideUrlLoading(WebView view, String url) {
					view.loadUrl(url);
					return true;
				}

				@Override
				public void onPageFinished(WebView view, String url) {
					super.onPageFinished(view, url);
					//Toast.makeText(getActivity(),"副屏加载地址"+url,Toast.LENGTH_SHORT).show();
				}
			});
			webView.setWebChromeClient(new WebChromeClient());
			webView.loadUrl(HttpUrl.secondScreenUrl);
			//webView.loadUrl("file:///android_asset/www/index.html");
			/*webView.loadUrl("https://www.baidu.com/");
			Bundle args = new Bundle();
			args.putString("KEY_PATH", "https://www.baidu.com/");
			CustomScreenFragment fragment = new CustomScreenFragment();
			fragment.setArguments(args);
			getSupportFragmentManager().beginTransaction()
					.replace(R.id.fragment_layout_container,fragment)
					.commit();*/

		}

		public WebView getWebView(){
			return webView;
		}
		@Override
		protected void onStart() {
			super.onStart();
		}

		@Override
		protected void onStop() {
			super.onStop();
		}

		@Override
		public void onDisplayRemoved() {
			super.onDisplayRemoved();

		}
	}

	// 用于接受连接状态消息的 Handler
	private Handler mHandler = new Handler() {
		@SuppressLint("ShowToast")
		@Override
		public void handleMessage(Message msg) {
			switch (msg.what) {
			case Connect.SUCCESS:
				isConnected = true;
				GlobalContants.ISCONNECTED = isConnected;
				GlobalContants.DEVICENAME = devicesName;
				/*if (interfaceType == 0) {
					PrefUtils.setString(mContext, GlobalContants.DEVICEADDRESS, devicesAddress);
					bluDisconnectFilter = new IntentFilter();
					bluDisconnectFilter.addAction(BluetoothDevice.ACTION_ACL_DISCONNECTED);
					mContext.registerReceiver(myReceiver, bluDisconnectFilter);
					hasRegDisconnectReceiver = true;
				}*/
				// TOTO 暂时将TSPL指令设置参数的设置放在这
				/*if (setPrinterTSPL(myPrinter)) {
					if (interfaceType == 0) {
						Toast.makeText(mContext, R.string.settingactivitty_toast_bluetooth_set_tspl_successful, 0)
								.show();
					} else if (interfaceType == 1) {
						Toast.makeText(mContext, R.string.settingactivity_toast_usb_set_tspl_succefful, 0).show();
					}
				}*/
				if(textBySmallPaperType!=null&&jsonObject!=null){
					printTextBySmallPaperMoneyMachine(jsonObject);
				}
				if(openCashBoxMachineFlag!=null){
					openCashBoxMachine();
				}

				break;
			case Connect.FAILED:
				isConnected = false;
				Toast.makeText(mContext, R.string.conn_failed, Toast.LENGTH_SHORT).show();
				Log.i(TAG, "连接失败!");
				break;
			case Connect.CLOSED:
				isConnected = false;
				GlobalContants.ISCONNECTED = isConnected;
				GlobalContants.DEVICENAME = devicesName;
				Toast.makeText(mContext, R.string.conn_closed, Toast.LENGTH_SHORT).show();
				Log.i(TAG, "连接关闭!");
				break;
			case Connect.NODEVICE:
				isConnected = false;
				Toast.makeText(mContext, R.string.conn_no, Toast.LENGTH_SHORT).show();
				break;
			case 0:
				Toast.makeText(mContext, "打印机通信正常!", Toast.LENGTH_SHORT).show();
				break;
			case -1:
				Toast.makeText(mContext, "打印机通信异常常，请检查蓝牙连接!",Toast.LENGTH_SHORT).show();
				vibrator();
				break;
			case -2:
				Toast.makeText(mContext, "打印机缺纸!", Toast.LENGTH_SHORT).show();
				vibrator();
				break;
			case -3:
				Toast.makeText(mContext, "打印机开盖!", Toast.LENGTH_SHORT).show();
				vibrator();
				break;
			// case 10:
			// if (setPrinterTSPL(myPrinter)) {
			// Toast.makeText(mContext, "蓝牙连接设置TSPL指令成功", 0).show();
			// }
			default:
				break;
			}

			updateButtonState(isConnected);

			if (dialog != null && dialog.isShowing()) {
				dialog.dismiss();
			}
		}

	};
	int count = 0;

	@SuppressWarnings("static-access")
	public void vibrator() {
		count++;
		PrefUtils.setInt(mContext, "count3", count);
		Log.e(TAG, "" + count);
		// Vibrator vib = (Vibrator) SettingActivity.this
		// .getSystemService(Service.VIBRATOR_SERVICE);
		// vib.vibrate(1000);
		// try {
		// Thread.sleep(500);
		// } catch (InterruptedException e) {
		// e.printStackTrace();
		// }
		MediaPlayer player = new MediaPlayer().create(mContext, R.raw.test);
		// MediaPlayer player2 = new MediaPlayer().create(mContext, R.raw.beep);

		player.start();
		// player2.start();
	}

	/**
	 * 初始化界面
	 */
	private void init() {
		mContext = CashHomeActivity.this;
		header = (LinearLayout) findViewById(R.id.ll_headerview_settingactivity);
		// 初始化标题
		initHeader();
		// 初始化下拉列表框
		// spinner_printer_type = (Spinner)
		// findViewById(R.id.spinner_printer_type);

		// 展示设备名和设备地址
		tv_device_name = (TextView) findViewById(R.id.tv_device_name);
		tv_printer_address = (TextView) findViewById(R.id.tv_printer_address);



		// 初始化对话框
		dialog = new ProgressDialog(mContext);
		dialog.setProgressStyle(ProgressDialog.STYLE_SPINNER);
		dialog.setTitle(getString(R.string.connecting));
		dialog.setMessage(getString(R.string.please_wait));
		dialog.setIndeterminate(true);
		dialog.setCancelable(false);

		getSaveState();
		updateButtonState(isConnected);
		// 初始化进度条对话框
		dialogH = new ProgressDialog(this);
		dialogH.setProgressStyle(ProgressDialog.STYLE_HORIZONTAL);
		dialogH.setCancelable(false);
		dialogH.setCanceledOnTouchOutside(false);



		//connect2Usb();
	}


	//用于初始化的时候默认帮它连接一个搜索出来的设备
	private void searchDeviceList(){
		UsbManager manager = (UsbManager) getSystemService(Context.USB_SERVICE);
		HashMap<String, UsbDevice> devices = manager.getDeviceList();
		deviceList = new ArrayList<UsbDevice>();
		for (UsbDevice device : devices.values()) {
			if (USBPort.isUsbPrinter(device)) {
				deviceList.add(device);
			}
		}
		//mUSBDevice = data.getParcelableExtra(UsbManager.EXTRA_DEVICE);
		if(deviceList.isEmpty()){
			Toast.makeText(this,"请连接开启可用设备",Toast.LENGTH_SHORT).show();
			return;
		}

		mUSBDevice =deviceList.get(0);
		//Toast.makeText(getApplicationContext(),deviceList.size()+"pos机"+mUSBDevice.getDeviceName()+"===="+mUSBDevice.getProductId(),Toast.LENGTH_SHORT).show();
		if(!mUSBDevice.getDeviceName().contains("/dev/bus/usb/001")){
			//Toast.makeText(this,"请连接开启可用pos机打印设备",Toast.LENGTH_SHORT).show();
			/*new AlertDialog.Builder(this).setTitle(R.string.str_message).setMessage(R.string.str_connlast)
					.setPositiveButton(R.string.yesconn, new DialogInterface.OnClickListener() {
						@SuppressLint("InlinedApi")
						@Override
						public void onClick(DialogInterface arg0, int arg1) {
							UsbManager manager = (UsbManager) getSystemService(Context.USB_SERVICE);
							usbAutoConn(manager);
						}
					}).setNegativeButton(R.string.str_resel, new DialogInterface.OnClickListener() {
				@Override
				public void onClick(DialogInterface dialog, int which) {
					Log.i("yxz", "点击监听事件+++++++++++++++++++++++++++++++++++++++++++" + isConnected);
					Intent intent = new Intent(mContext, UsbDeviceList.class);
					startActivityForResult(intent, CONNECT_DEVICE);
				}
			}).show();*/
			new AlertDialog.Builder(this).setTitle("提示").setMessage("请连接开启可用pos机打印设备")
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
		/*if (!USBPort.isUsbPrinter(mUSBDevice)) {
			Toast.makeText(this,"请连接开启到可用pos机打印设备",Toast.LENGTH_SHORT).show();
			new AlertDialog.Builder(this).setTitle(R.string.str_message).setMessage(R.string.str_connlast)
					.setPositiveButton(R.string.yesconn, new DialogInterface.OnClickListener() {
						@SuppressLint("InlinedApi")
						@Override
						public void onClick(DialogInterface arg0, int arg1) {
							UsbManager manager = (UsbManager) getSystemService(Context.USB_SERVICE);
							usbAutoConn(manager);
						}
					}).setNegativeButton(R.string.str_resel, new DialogInterface.OnClickListener() {
				@Override
				public void onClick(DialogInterface dialog, int which) {
					Log.i("yxz", "点击监听事件+++++++++++++++++++++++++++++++++++++++++++" + isConnected);
					Intent intent = new Intent(mContext, UsbDeviceList.class);
					startActivityForResult(intent, CONNECT_DEVICE);
				}
			}).show();
			return;
		}*/
		myPrinter = PrinterInstance.getPrinterInstance(mContext, mUSBDevice, mHandler);
		devicesName = "USB device";
		UsbManager mUsbManager = (UsbManager) mContext.getSystemService(Context.USB_SERVICE);
		if (mUsbManager.hasPermission(mUSBDevice)) {
			myPrinter.openConnection();
		} else {
			// 没有权限询问用户是否授予权限
			PendingIntent pendingIntent = PendingIntent.getBroadcast(mContext, 0,
					new Intent(ACTION_USB_PERMISSION), 0);
			IntentFilter filter = new IntentFilter(ACTION_USB_PERMISSION);
			filter.addAction(UsbManager.ACTION_USB_DEVICE_ATTACHED);
			filter.addAction(UsbManager.ACTION_USB_DEVICE_DETACHED);
			mContext.registerReceiver(mUsbReceiver, filter);
			mUsbManager.requestPermission(mUSBDevice, pendingIntent); // 该代码执行后，系统弹出一个对话框
		}
	}

	private void getSaveState() {
		isConnected = PrefUtils.getBoolean(CashHomeActivity.this, GlobalContants.CONNECTSTATE, false);
		//printerId = PrefUtils.getInt(mContext, GlobalContants.PRINTERID, 0);
		interfaceType = PrefUtils.getInt(mContext, GlobalContants.INTERFACETYPE, 0);
		// spinner_printer_type.setSelection(printerId);
		//spinner_interface_type.setSelection(interfaceType);
		Log.i(TAG, "isConnected:" + isConnected);
	}

	/**
	 * 初始化标题上的信息
	 */
	private void initHeader() {
		// setHeaderLeftText(header, getString(R.string.back),
		// new OnClickListener() {
		//
		// @Override
		// public void onClick(View v) {
		// finish();
		//
		// }
		// });
		setHeaderLeftImage(header, new OnClickListener() {// 初始化了
			// headerConnecedState
			@Override
			public void onClick(View v) {
				finish();
			}
		});
		setHeaderCenterText(header, getString(R.string.headview_setting));
	}

	@Override
	protected void onStart() {
		super.onStart();

	}

	@Override
	protected void onResume() {
		super.onResume();
	}

	@Override
	protected void onRestart() {
		super.onRestart();

	}

	@Override
	protected void onPause() {
		super.onPause();

	}

	@Override
	protected void onStop() {
		super.onStop();

	}

	@Override
	public void finish() {
		if (myPrinter != null) {
			myPrinter.closeConnection();
			myPrinter = null;
		}
		if(openCashBoxMachineFlag!=null||textBySmallPaperType!=null){
			openCashBoxMachineFlag=null;
			textBySmallPaperType=null;
		}
		super.finish();
	}

	@Override
	public void onDestroy() {
		super.onDestroy();
		if (myPrinter != null) {
			myPrinter.closeConnection();
			myPrinter = null;
			Log.i(TAG, "已经断开");

		}

	}

	//连接到USB
	private void connect2Usb(){
		Log.i(TAG, "isConnected:" + isConnected);
		if (!isConnected) {
			switch (interfaceType) {
				case 1:// USB
					/*new AlertDialog.Builder(this).setTitle(R.string.str_message).setMessage(R.string.str_connlast)
							.setPositiveButton(R.string.yesconn, new DialogInterface.OnClickListener() {
								@SuppressLint("InlinedApi")
								@Override
								public void onClick(DialogInterface arg0, int arg1) {

									UsbManager manager = (UsbManager) getSystemService(Context.USB_SERVICE);
									usbAutoConn(manager);
								}
							}).setNegativeButton(R.string.str_resel, new DialogInterface.OnClickListener() {

						@Override
						public void onClick(DialogInterface dialog, int which) {
							Log.i("yxz", "点击监听事件+++++++++++++++++++++++++++++++++++++++++++" + isConnected);
							Intent intent = new Intent(mContext, UsbDeviceList.class);
							startActivityForResult(intent, CONNECT_DEVICE);
						}

					}).show();*/
					//搜索设备连接
					searchDeviceList();
					break;

				default:
					break;
			}
		} else {
			textBySmallPaperType=null;
			/*if (myPrinter != null) {
				myPrinter.closeConnection();
				myPrinter = null;
				Log.i(TAG, "已经断开");

			}*/
			//如果连接成功

		}
	}
	private String openCashBoxMachineFlag=null;
	public void openCashBoxMachine(){

		if (PrinterInstance.mPrinter != null &&isConnected) {
			openCashBoxMachineFlag=null;
			new Thread(new Runnable() {
				@Override
				public void run() {
					myPrinter.openCashbox(true,true);
				}
			}).start();
		}else {
			//打印机未连接，去连接
			openCashBoxMachineFlag="openCashBoxMachine";
			connect2Usb();
			//Toast.makeText(mContext, getString(R.string.no_connected), Toast.LENGTH_SHORT).show();
		}
	}


	private JSONObject jsonObject;
	private String textBySmallPaperType=null;//用于标记打开app之后再开启连接小票机打印
	//小票机文本打印
	public void printTextBySmallPaperMoneyMachine(final JSONObject object){
		jsonObject=object;
		//WIFI 由于是网络操作，需要放到线程中，其他通信方式可以放在线程中也可以不必如此
		if (PrinterInstance.mPrinter != null &&isConnected) {
			textBySmallPaperType=null;
			new Thread(new  Runnable() {
				public void run() {
					XTUtils.printCoffeeNote(CashHomeActivity.this,object, myPrinter,true);
					jsonObject=null;
				}
			}).start();
			//XTUtils.printTest(getResources(), myPrinter);
//				PrintLottery.printLottery(mContext, myPrinter);
//				new Thread(new  Runnable() {
//					public void run() {
////						new CodePagePrinter(myPrinter).printTextInWCP1258("Trường hợp kiểm tra in tiếng Việt\n");
//					}
//				}).start();
		} else {
			//打印机未连接，去连接
			textBySmallPaperType="printTextBySmallPaperMoneyMachine";
			connect2Usb();
			//Toast.makeText(mContext, getString(R.string.no_connected), Toast.LENGTH_SHORT).show();
		}
	}

	////小票机打印可以设置大小的字体文本标签
	public void printLabelTextBySmallPaperMoneyMachine(){
		if (PrinterInstance.mPrinter != null &&isConnected) {
			XTUtils.printTest(getResources(), myPrinter);
		} else {
			//打印机未连接，去连接
			connect2Usb();
			Toast.makeText(mContext, getString(R.string.no_connected), Toast.LENGTH_SHORT).show();
		}
	}
	// 安卓3.1以后才有权限操作USB
	@SuppressLint("ShowToast")
	@TargetApi(Build.VERSION_CODES.HONEYCOMB_MR1)
	@Override
	protected void onActivityResult(int requestCode, int resultCode, Intent data) {
		super.onActivityResult(requestCode, resultCode, data);
		if (resultCode != Activity.RESULT_OK)
			return;
		if (requestCode == CONNECT_DEVICE) {// 连接设备
			if (interfaceType == 0) {
				devicesAddress = data.getExtras().getString(BluetoothDeviceList.EXTRA_DEVICE_ADDRESS);
				devicesName = data.getExtras().getString(BluetoothDeviceList.EXTRA_DEVICE_NAME);
			} else if (interfaceType == 1)// usb
			{
				mUSBDevice = data.getParcelableExtra(UsbManager.EXTRA_DEVICE);
				myPrinter = PrinterInstance.getPrinterInstance(mContext, mUSBDevice, mHandler);
				devicesName = "USB device";
				UsbManager mUsbManager = (UsbManager) mContext.getSystemService(Context.USB_SERVICE);
				if (mUsbManager.hasPermission(mUSBDevice)) {
					myPrinter.openConnection();
				} else {
					// 没有权限询问用户是否授予权限
					PendingIntent pendingIntent = PendingIntent.getBroadcast(mContext, 0,
							new Intent(ACTION_USB_PERMISSION), 0);
					IntentFilter filter = new IntentFilter(ACTION_USB_PERMISSION);
					filter.addAction(UsbManager.ACTION_USB_DEVICE_ATTACHED);
					filter.addAction(UsbManager.ACTION_USB_DEVICE_DETACHED);
					mContext.registerReceiver(mUsbReceiver, filter);
					mUsbManager.requestPermission(mUSBDevice, pendingIntent); // 该代码执行后，系统弹出一个对话框
				}

			}
		}
	}


	private void updateButtonState(boolean isConnected) {
		if (isConnected) {
			headerConnecedState.setText(R.string.on_line);
			//btn_search_devices.setText(R.string.disconnect);
			setTitleState(mContext.getResources().getString(R.string.on_line));
			Log.i("fdh", getString(R.string.printerName).split(":")[0]);
			Log.i("fdh", getString(R.string.printerAddress).split(":")[0]);
			tv_device_name.setText(getString(R.string.printerName).split(":")[0] + ": " + devicesName);
			tv_printer_address.setText(getString(R.string.printerAddress).split(":")[0] + ": " + devicesAddress);
		} else {
			//btn_search_devices.setText(R.string.connect);
			headerConnecedState.setText(R.string.off_line);
			setTitleState(mContext.getResources().getString(R.string.off_line));
			tv_device_name.setText(getString(R.string.printerName));
			tv_printer_address.setText(getString(R.string.printerAddress));
			// mHandler.removeCallbacks(runnable);
			// if (isFirst) {
			//
			// } else {
			// timer.cancel();
			// }
			// Log.i(TAG, "定时器取消了");

		}

		PrefUtils.setBoolean(CashHomeActivity.this, GlobalContants.CONNECTSTATE, isConnected);

	}


	private final BroadcastReceiver mUsbReceiver = new BroadcastReceiver() {
		@SuppressLint("NewApi")
		public void onReceive(Context context, Intent intent) {
			String action = intent.getAction();
			Log.w(TAG, "receiver action: " + action);

			if (ACTION_USB_PERMISSION.equals(action)) {
				synchronized (this) {
					mContext.unregisterReceiver(mUsbReceiver);
					UsbDevice device = (UsbDevice) intent.getParcelableExtra(UsbManager.EXTRA_DEVICE);
					if (intent.getBooleanExtra(UsbManager.EXTRA_PERMISSION_GRANTED, false)
							&& mUSBDevice.equals(device)) {
						if(myPrinter!=null){
							myPrinter.openConnection();
						}
					} else {
						mHandler.obtainMessage(Connect.FAILED).sendToTarget();
						Log.e(TAG, "permission denied for device " + device);
					}
				}
			}
		}
	};




	// @Override
	// protected void onNewIntent(Intent intent) {
	// super.onNewIntent(intent);
	// }



	/*
	 * @Override public void onConfigurationChanged(Configuration newConfig) {
	 * super.onConfigurationChanged(newConfig); if
	 * (this.getResources().getConfiguration().orientation ==
	 * Configuration.ORIENTATION_LANDSCAPE) { // land } else if
	 * (this.getResources().getConfiguration().orientation ==
	 * Configuration.ORIENTATION_PORTRAIT) { // port } }
	 */

	public void usbAutoConn(UsbManager manager) {

		doDiscovery(manager);

		if (!deviceList.isEmpty()) {
			mUSBDevice = deviceList.get(0);
		}
		if (mUSBDevice != null) {
			PrinterInstance.getPrinterInstance(mContext, mUSBDevice, mHandler).openConnection();
		} else {
			mHandler.obtainMessage(Connect.FAILED).sendToTarget();
			myPrinter.closeConnection();
		}
	}

	@SuppressLint("NewApi")
	private void doDiscovery(UsbManager manager) {
		HashMap<String, UsbDevice> devices = manager.getDeviceList();
		deviceList = new ArrayList<UsbDevice>();
		for (UsbDevice device : devices.values()) {
			if (USBPort.isUsbPrinter(device)) {
				deviceList.add(device);
			}
		}

	}

}
