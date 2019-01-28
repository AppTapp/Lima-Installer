#import <stdio.h>
//#import <Foundation/Foundation.h>
//#import <CoreFoundation/CoreFoundation.h>
#include <unistd.h>
#import "device.h"
int main(int argc, char **argv, char **envp)
{
NSAutoreleasePool *pool = [[NSAutoreleasePool alloc] init];
NSArray *args = [[NSProcessInfo processInfo] arguments];
//to start the server an argument is supplied
if([args count] == 2)
{
NSLog(@"LimaService starting NOW!");
device *dev = [device alloc];
NSLog(@"%@",[dev GetInstalled]);
//system("socat TCP-LISTEN:1337,fork,reuseaddr exec:\"/usr/sbin/LimaService\"");
//although this should never quit just exit incase it crashes
exit(0);
}
//this is request, time to process it
    char request[1000];
    NSString *ClientData;
    fgets(request, 1000, stdin);
    ClientData = [[NSString alloc] initWithUTF8String:request];
    NSLog(@"%@",ClientData);
device *dev = [device alloc];
NSLog(@"%@",[dev GetUdid]);
NSLog(@"%@",[dev GetUuid:@"test"]);
return 0;
[pool drain];
}

