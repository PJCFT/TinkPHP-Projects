#include "Data_Acquisition.h"
#include "Data_Processing.h"
#include <iostream>
std::string The_Position[25];//定义关节位置
void NumberOfFrames::GetTimes(const int Data)
{
	Times = Data;
}

void ini_OutputToFile()
{
	char a[][30] = {
		"1      Spine_Base: ",//脊柱底部
		"2       Spine_Mid: ",//脊柱中部
		"3            Neck: ",//颈部
		"4            Head: ",//头
		"5   Shoulder_Left: ",//左肩
		"6      Elbow_Left: ",//左肘
		"7      Wrist_Left: ",//左手腕
		"8       Hand_Left: ",//左手
		"9  Shoulder_Right: ",//右肩膀
		"10    Elbow_Right: ",//右肘
		"11    Wrist_Right: ",//右手腕
		"12     Hand_Right: ",//右手
		"13       Hip_Left: ",//左髋
		"14      Knee_Left: ",//左膝
		"15     Ankle_Left: ",//左踝
		"16      Foot_Left: ",//左足
		"17      Hip_Right: ",//右髋
		"18     Knee_Right: ",//右膝
		"19    Ankle_Right: ",//右踝
		"20     Foot_Right: ",//右脚
		"21 Spine_Shoulder: ",//脊柱肩
		"22  Hand_Tip_Left: ",//左手部顶端
		"23     Thumb_Left: ",//左拇指
		"24 Hand_Tip_Right: ",//右手部顶端
		"25    Thumb_Right: "//右拇指
	};//位置命名
	for (int i = 0; i < 25; i++)
		The_Position[i] = a[i];
}

//void DataToVector(float X, float Y)
//{
//	OutputToFile tmp;
//	tmp.X = X;
//	tmp.Y = Y;
//	Data.push_back(tmp);
//}