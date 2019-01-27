#import <stdio.h>
#include <unistd.h>
#import "device.h"
#import "Downloader.h"
int main(int argc, char **argv, char **envp)
{
NSAutoreleasePool *pool = [[NSAutoreleasePool alloc] init];

//debug
//Downloader *dl=[Downloader alloc];
NSLog(@"made dl");
//[dl release];
//debug end
NSArray *args = [[NSProcessInfo processInfo] arguments];
//to start the server an argument is supplied
if([args count] == 2)
{
NSLog(@"LimaService starting NOW!");
system("export LIMA_PACKAGE_NUMBER=0");
system("socat TCP-LISTEN:1337,fork,reuseaddr exec:\"/usr/sbin/LimaService\"");
//although this should never quit just exit incase it crashes
NSLog(@"Bye Bye :(");
exit(0);
}
//this is request, time to process it
char request[1000];
NSString *ClientData;
fgets(request, 1000, stdin);
ClientData = [[NSString alloc] initWithUTF8String:request];
device *serv = [device alloc];
NSLog(@"incoming request");
[serv Respond:[serv ProcessData:ClientData]];
return 0;
[pool drain];
}

