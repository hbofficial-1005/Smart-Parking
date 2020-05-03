package kz.qrscan.qrscanner.Activity;

import android.content.Intent;
import android.os.Bundle;

import android.view.View;
import android.widget.EditText;

import androidx.appcompat.app.AppCompatActivity;

import com.google.gson.Gson;
import com.google.gson.GsonBuilder;

import kz.qrscan.qrscanner.R;
import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;


public class LoginActivity extends AppCompatActivity {

    private API api;
    @Override
    protected void onCreate(Bundle savedInstanceState){
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_login);
    }
    public void onclick(View view){
        Intent intent= new Intent(this, SignUp.class);
        startActivity(intent);

    }
    public void onClick(View view){
        EditText editText =(EditText)findViewById(R.id.pno);
        String user = editText.getText().toString();
        Intent intent= new Intent(this, WelcomeActivity.class);
        intent.putExtra("user",user);
        startActivity(intent);

    }
}
