#import "device.h"
@implementation device
    
-(id) GetUdid
{
NSTask *execer = [NSTask new];
[execer setLaunchPath:@"/usr/bin/uiduid"];
[execer setArguments:[NSArray arrayWithObject:@"-g"]];
NSPipe *outputPipe = [NSPipe pipe];
[execer setStandardInput:[NSPipe pipe]];
[execer setStandardOutput:outputPipe];

[execer launch];

[execer release];

NSData *outputData = [[outputPipe fileHandleForReading] readDataToEndOfFile];
NSString *udid = [[[NSString alloc] initWithData:outputData encoding:NSUTF8StringEncoding] autorelease];

return udid;
}
-(id) GetUuid: (NSString*)input
{
@try {
NSString *filePath = @"/private/var/mobile/Library/Preferences/com.limainstaller.auth.plist";
NSMutableDictionary* plistDict = [[NSMutableDictionary alloc] initWithContentsOfFile:filePath];
NSString *uuid = [plistDict objectForKey:input];
return uuid;
}
@catch (id theException)  {
return @"NO_SETUP";
}
}

-(id) GetInstalled
{
NSString *output = @"";
NSString *Package = @"-";
NSString *Version = @"-";
NSString *Description = @"-";
NSString *Name = @"-";
NSString *fh = [NSString stringWithContentsOfFile:@"/var/lib/dpkg/status" encoding:NSUTF8StringEncoding error:NULL];
for (NSString *line in [fh componentsSeparatedByString:@"\n"]) {
NSArray *propertyandvalue = [line componentsSeparatedByString:@": "];
@try {
NSString *property = [propertyandvalue objectAtIndex:0];
NSString *value = [propertyandvalue objectAtIndex:1];
if([property isEqualToString:@"Package"])
{
Package = value;
} else if([property isEqualToString:@"Version"])
{
Version = value;
} else if([property isEqualToString:@"Name"])
{
Name= value;
} else if([property isEqualToString:@"Description"])
{
Description = value;
} 
} @catch (id ex) { //ok I admit, this is very dirty 
output = [[[[[[[[[output stringByAppendingString:@"$("] stringByAppendingString:Package] stringByAppendingString:@"`,`"] stringByAppendingString:Version] stringByAppendingString:@"`,`"] stringByAppendingString:Name] stringByAppendingString:@"`,`"] stringByAppendingString:Description] stringByAppendingString:@")"];
Package = @"-";
Description = @"-";
Name = @"-";
Version = @"-";
}
}
return output;
}
@end
