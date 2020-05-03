package kz.qrscan.qrscanner.Activity;

import android.Manifest;
import android.app.Dialog;
import android.content.ClipData;
import android.content.ClipboardManager;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.pm.PackageManager;
import android.icu.util.Calendar;


import android.os.Bundle;
import android.view.View;
import android.view.ViewGroup;
import android.view.Window;
import android.widget.Button;
import android.widget.ImageView;
import android.widget.TextView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;
import androidx.core.app.ActivityCompat;

import com.android.volley.AuthFailureError;
import com.android.volley.Request;
import com.android.volley.RequestQueue;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.JsonObjectRequest;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;
import com.google.gson.Gson;
import com.google.gson.GsonBuilder;
import com.google.zxing.Result;

import org.json.JSONArray;
import org.json.JSONObject;

import java.util.HashMap;
import java.util.Map;

import butterknife.OnClick;
import kz.qrscan.qrscanner.Entity.History;
import kz.qrscan.qrscanner.R;
import kz.qrscan.qrscanner.SQLite.ORM.HistoryORM;
import me.dm7.barcodescanner.zxing.ZXingScannerView;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;

public class MainActivity extends AppCompatActivity implements ZXingScannerView.ResultHandler {

    // Init ui elements
//    @BindView(R.id.lightButton) ImageView flashImageView;

    //Variables
    Intent i;
    HistoryORM h = new HistoryORM();
    private ZXingScannerView mScannerView;
    private boolean flashState = false;
    private API api;
    String user;
    //String insertUrl = "http://192.168.43.226/bristlecone/book.php";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        ActivityCompat.requestPermissions(MainActivity.this,
                new String[]{Manifest.permission.CAMERA},
                1);
        Gson gson = new GsonBuilder()
                .setLenient()
                .create();

        Retrofit retrofit = new Retrofit.Builder()
                .baseUrl(API.BASE_URL)
                .addConverterFactory(GsonConverterFactory.create(gson))
                .build();
        api = retrofit.create(API.class);
        user = getIntent().getStringExtra("user");
        ViewGroup contentFrame = (ViewGroup) findViewById(R.id.content_frame);
        mScannerView = new ZXingScannerView(this);
        contentFrame.addView(mScannerView);
    }

    @Override
    public void onResume() {
        super.onResume();
        mScannerView.setResultHandler(this);
        mScannerView.startCamera();
    }

    @Override
    public void onPause() {
        super.onPause();
        mScannerView.stopCamera();
    }

    @Override
    public void handleResult(final Result rawResult) {

        // adding result to history
        String mydate = java.text.DateFormat.getDateTimeInstance().format(Calendar.getInstance().getTime());
        History history = new History();
        history.setContext(rawResult.getText());
        history.setDate(mydate);
        h.add(getApplicationContext(), history);

        // show custom alert dialog
        final Dialog dialog = new Dialog(this);
        dialog.requestWindowFeature(Window.FEATURE_NO_TITLE);
        dialog.setCancelable(true);
        dialog.setContentView(R.layout.custom_dialog);

        View v = dialog.getWindow().getDecorView();
        v.setBackgroundResource(android.R.color.transparent);

        TextView text = (TextView) dialog.findViewById(R.id.someText);
        final String message = rawResult.getText();
        if(rawResult.getText().equals("6"))
        {
            text.setText("Your parking spot is free");
        }
        else {
            text.setText("Your parking spot is " + rawResult.getText());
        }
        ImageView img = (ImageView) dialog.findViewById(R.id.imgOfDialog);
        img.setImageResource(R.drawable.ic_done_gr);

        Button webSearch = (Button) dialog.findViewById(R.id.searchButton);
        Button copy = (Button) dialog.findViewById(R.id.copyButton);
        Button share = (Button) dialog.findViewById(R.id.shareButton);
        final String spot =rawResult.getText();
        webSearch.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                if(rawResult.getText().equals("6"))
                {
                    Call<free> call=api.free(spot,user);
                    call.enqueue(new Callback<free>() {
                        @Override
                        public void onResponse(Call<free> call, Response<free> response) {
                            Intent intent = new Intent(MainActivity.this, WelcomeActivity.class);
                            intent.putExtra("user",user);
                            startActivity(intent);
                            dialog.dismiss();
                        }

                        @Override
                        public void onFailure(Call<free> call, Throwable t) {
                            Intent intent = new Intent(MainActivity.this, WelcomeActivity.class);
                            intent.putExtra("user",user);
                            startActivity(intent);
                            dialog.dismiss();
                        }
                    });
                }
                else{
                        Call<book> call = api.book(spot,user);
                        call.enqueue(new Callback<book>() {
                            @Override
                            public void onResponse(Call<book> call, Response<book> response) {
                                Intent intent = new Intent(MainActivity.this, WelcomeActivity.class);
                                intent.putExtra("user",user);
                                startActivity(intent);
                                dialog.dismiss();
                            }

                            @Override
                            public void onFailure(Call<book> call, Throwable t) {
                                Intent intent = new Intent(MainActivity.this, WelcomeActivity.class);
                                intent.putExtra("user",user);
                                startActivity(intent);
                                dialog.dismiss();
                            }
                        });

                }




                //mScannerView.resumeCameraPreview(MainActivity.this);
            }
        });
        copy.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                ClipboardManager clipboard = (ClipboardManager) getSystemService(Context.CLIPBOARD_SERVICE);
                ClipData clip = ClipData.newPlainText("", rawResult.getText());
                clipboard.setPrimaryClip(clip);

                Toast.makeText(getApplicationContext(), "Copied to clipboard", Toast.LENGTH_SHORT).show();

                dialog.dismiss();
                mScannerView.resumeCameraPreview(MainActivity.this);
            }
        });
        share.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                Intent sharingIntent = new Intent(android.content.Intent.ACTION_SEND);
                sharingIntent.setType("text/plain");
                String shareBody = rawResult.getText();
                sharingIntent.putExtra(android.content.Intent.EXTRA_TEXT, shareBody);
                startActivity(Intent.createChooser(sharingIntent, "Share "));

                dialog.dismiss();
                mScannerView.resumeCameraPreview(MainActivity.this);
            }
        });
        dialog.setOnCancelListener(new DialogInterface.OnCancelListener() {
            @Override
            public void onCancel(DialogInterface dialog) {
                mScannerView.resumeCameraPreview(MainActivity.this);
            }
        });
        dialog.show();
    }

    @Override
    public void onRequestPermissionsResult(int requestCode, String permissions[], int[] grantResults) {
        switch (requestCode) {
            case 1: {
                if (grantResults.length > 0
                        && grantResults[0] == PackageManager.PERMISSION_GRANTED) {
                } else {
                    Toast.makeText(MainActivity.this, "Permission denied to camera", Toast.LENGTH_SHORT).show();
                }
                return;
            }
        }
    }


}
