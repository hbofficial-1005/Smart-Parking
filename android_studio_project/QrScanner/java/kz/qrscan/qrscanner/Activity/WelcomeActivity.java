package kz.qrscan.qrscanner.Activity;

import android.content.Intent;
import android.os.Bundle;
import android.view.View;
import android.widget.ImageView;
import android.widget.Toast;

import androidx.appcompat.app.AppCompatActivity;

import com.google.gson.Gson;
import com.google.gson.GsonBuilder;

import java.util.ArrayList;

import kz.qrscan.qrscanner.R;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;

public class WelcomeActivity extends AppCompatActivity {
    String user;
    private API api;
    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_welcome);
        user = getIntent().getStringExtra("user");
        //Toast.makeText(getApplicationContext(),user, Toast.LENGTH_LONG).show();
        ImageView imageView = (ImageView) findViewById(R.id.iv1);
        ImageView imageView1= (ImageView) findViewById(R.id.iv2);
        ImageView imageView2 = (ImageView) findViewById(R.id.iv3);
        ImageView imageView3 = (ImageView) findViewById(R.id.iv4);
        ImageView imageView4 = (ImageView) findViewById(R.id.iv5);
        Gson gson = new GsonBuilder()
                .setLenient()
                .create();
        Retrofit retrofit = new Retrofit.Builder()
                .baseUrl(API.BASE_URL)
                .addConverterFactory(GsonConverterFactory.create(gson))
                .build();
        api = retrofit.create(API.class);
        Call<show> call1 = api.getStatus();
        call1.enqueue(new Callback<show>() {
            @Override
            public void onResponse(Call<show> call, Response<show> response) {
                show show = response.body();
                String available_spot = show.getShow().get(0);
                String available_spot1 = show.getShow().get(1);
                String available_spot2 = show.getShow().get(2);
                String available_spot3 = show.getShow().get(3);
                String available_spot4 = show.getShow().get(4);
                if(available_spot.equals("0"))
                {
                    imageView.setImageDrawable(getResources().getDrawable(R.drawable.green));
                }
                else
                {
                    imageView.setImageDrawable(getResources().getDrawable(R.drawable.red));
                }
                if(available_spot1.equals("0"))
                {
                    imageView1.setImageDrawable(getResources().getDrawable(R.drawable.green));
                }
                else
                {
                    imageView1.setImageDrawable(getResources().getDrawable(R.drawable.red));
                }
                if(available_spot2.equals("0"))
                {
                    imageView2.setImageDrawable(getResources().getDrawable(R.drawable.green));
                }
                else
                {
                    imageView2.setImageDrawable(getResources().getDrawable(R.drawable.red));
                }
                if(available_spot3.equals("0"))
                {
                    imageView3.setImageDrawable(getResources().getDrawable(R.drawable.green));
                }
                else
                {
                    imageView3.setImageDrawable(getResources().getDrawable(R.drawable.red));
                }
                if(available_spot4.equals("0"))
                {
                    imageView4.setImageDrawable(getResources().getDrawable(R.drawable.green));
                }
                else
                {
                    imageView4.setImageDrawable(getResources().getDrawable(R.drawable.red));
                }
            }

            @Override
            public void onFailure(Call<show> call, Throwable t) {
                Toast.makeText(getApplicationContext(),t.getMessage(), Toast.LENGTH_LONG).show();
            }
        });

    }

    public void onClick(View view) {
        Intent intent = new Intent(this, MainActivity.class);
        //Toast.makeText(getApplicationContext(),user, Toast.LENGTH_LONG).show();
        intent.putExtra("user",user);
        startActivity(intent);


    }

}
