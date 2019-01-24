package common.utils;

import android.os.Handler;
import android.widget.ImageView;
import android.widget.TextView;

import java.util.Timer;
import java.util.TimerTask;

import chat.rocket.android.widget.R;


public class VoicePlayingBgUtil {
    private Handler handler;

    private TextView imageView;

    private Timer timer = new Timer();
    private TimerTask timerTask;

    private int i;

    private int modelType = 1;//类型

    private int[] leftVoiceBg = new int[] { R.drawable.left_voice_one, R.drawable.left_voice_two, R.drawable.left_voice_three };
    private int[] rightVoiceBg = new int[] { R.drawable.right_voice_one, R.drawable.right_voice_two, R.drawable.right_voice_three };
    //private int[] collectVoiceBg = new int[] { R.drawable.collect_voice_1, R.drawable.collect_voice_2, R.drawable.collect_voice_3 };

    public VoicePlayingBgUtil() {
        super();
        this.handler = new Handler();
    }


    public void voicePlay() {
        if (imageView == null) {
            return;
        }
        if (timerTask != null) {
            timerTask.cancel();
        }
        i = 0;
        timerTask = new TimerTask() {

            @Override
            public void run() {
                if (imageView != null) {
                    if (modelType == 1) {
                        changeBg(leftVoiceBg[i % 3], false);
                    }else if(modelType==2){
                        changeBg(rightVoiceBg[i % 3], false);
                    }else if(modelType==3){
                        //changeBg(collectVoiceBg[i % 3], false);
                    }
                }
                else {
                    return;
                }
                i++;
            }
        };
        timer.schedule(timerTask, 0, 500);
    }

    public void stopPlay() {
        if (imageView != null) {
            switch (modelType) {
                case 1:
                    changeBg(R.drawable.left_voice_three, true);
                    break;
                case 2:
                    changeBg(R.drawable.right_voice_three, true);
                    break;
                case 3:
                    //changeBg(R.drawable.collect_voice_3, true);
                default:
                    //changeBg(R.drawable.gray3, true);
                    break;
            }
            if (timerTask != null) {
                timerTask.cancel();
            }
        }
    }

    private void changeBg(final int id, final boolean isStop) {

        handler.post(new Runnable() {
            @Override
            public void run() {
                /*if (isStop) {
                    if(modelType==1){
                        lastImageView.setCompoundDrawablesWithIntrinsicBounds(id,0,0,0);
                    }else {
                        lastImageView.setCompoundDrawablesWithIntrinsicBounds(0,0,id,0);
                    }
                }else {
                    //imageView.setImageResource(id);
                }*/
                if(modelType==1){
                    imageView.setCompoundDrawablesWithIntrinsicBounds(id,0,0,0);
                }else {
                    imageView.setCompoundDrawablesWithIntrinsicBounds(0,0,id,0);
                }
            }
        });
    }

    public void setImageView(TextView imageView) {
        this.imageView = imageView;
    }

    public void setModelType(int modelType) {
        this.modelType = modelType;
    }
}
