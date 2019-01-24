package com.printer.receipt;

import cashier.vdao.app.R;

import android.os.Bundle;
import android.util.Log;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.LinearLayout;
import android.widget.Toast;
import android.widget.ToggleButton;

import com.printer.receipt.utils.XTUtils;
import com.printer.sdk.PrinterInstance;

public class TextPrintActivity extends BaseActivity implements OnClickListener{

	private static final String TAG = "TextPrintActivity";
	private LinearLayout header;
	private Button  btn_print_note/*, btn_print_table, btn_print_codepaper*/;
	private ToggleButton tb_isHexData;
	//private boolean isHexData = false;
	private static PrinterInstance mPrinter;
	private String input;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		Log.i(TAG, " TextPrintActivity onCreate");
		setContentView(R.layout.activity_print_text);
		init();
		mPrinter = PrinterInstance.mPrinter;
		// PrinterConstants.paperWidth =
		// PrefUtils.getInt(TextPrintActivity.this,
		// GlobalContants.PAPERWIDTH, 384);
		// Log.i(TAG, "paperWidth:" + PrinterConstants.paperWidth);

	}

	@Override
	protected void onResume() {
		super.onResume();
		// if (GlobalContants.ISCONNECTED) {
		// if ("".equals(GlobalContants.DEVICENAME)
		// || GlobalContants.DEVICENAME == null) {
		// headerConnecedState.setText(R.string.unknown_device);
		//
		// } else {
		//
		// headerConnecedState.setText(GlobalContants.DEVICENAME);
		// }
		//
		// }

	}

	private void init() {

		header = (LinearLayout) findViewById(R.id.ll_headerview_textPrint);

		btn_print_note = (Button) findViewById(R.id.btn_print_note);
		btn_print_note.setOnClickListener(this);
		/*btn_print_table = (Button) findViewById(R.id.btn_print_table);
		btn_print_table.setOnClickListener(this);
		btn_print_codepaper = (Button) findViewById(R.id.btn_print_codepaper);
		btn_print_codepaper.setOnClickListener(this);
		btn_send.setOnClickListener(this);*/
		/*tb_isHexData = (ToggleButton) findViewById(R.id.tb_hex_on);
		tb_isHexData.setOnCheckedChangeListener(this);*/
		//isHexData = tb_isHexData.isChecked();
		initHeader();
	}

	/**
	 * 初始化标题上的信息
	 */
	private void initHeader() {
		setHeaderLeftText(header, getString(R.string.back), new OnClickListener() {

			@Override
			public void onClick(View v) {
				finish();

			}
		});
		headerConnecedState.setText(getTitleState());
		setHeaderCenterText(header, getString(R.string.headview_TextPrint));
		setHeaderLeftImage(header, new OnClickListener() {

			@Override
			public void onClick(View v) {
				finish();
			}
		});

	}

	@Override
	public void onClick(View view) {
		if (PrinterInstance.mPrinter != null && CashHomeActivity.isConnected) {
			if (view == btn_print_note) {
				new Thread(new  Runnable() {
					public void run() {
						XTUtils.printNote(TextPrintActivity.this.getResources(), mPrinter);
					}
				}).start();
				
			} /*else if (view == btn_print_codepaper) {
				new CodePageUtils().selectCodePage(this, PrinterInstance.mPrinter);
			}*/
		} else {
			Toast.makeText(TextPrintActivity.this, getString(R.string.no_connected), Toast.LENGTH_SHORT).show();
		}

	}

	/*@Override
	public void onCheckedChanged(CompoundButton buttonView, boolean isChecked) {

		if (isChecked) {// 16进制开
			isHexData = true;
			byte[] datas;
			try {
				datas = input.getBytes("GBK");
				et_input.setText(XTUtils.bytesToHexString(datas, datas.length));
				input = et_input.getText().toString();
			} catch (UnsupportedEncodingException e) {
				e.printStackTrace();
			}
		} else {
			isHexData = false;
			if (input == null || input.length() == 0) {
				et_input.setText(R.string.textprintactivty_input_content);
			} else {
				et_input.setText(XTUtils.hexStringToString(input));
				input = et_input.getText().toString();
			}
		}

	}*/

}
