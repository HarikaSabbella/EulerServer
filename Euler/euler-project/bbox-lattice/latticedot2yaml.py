import sys
import re
import yaml

def addNode(name, type):
    node = {}
    node.update({"name": name})
    node.update({"type": type})
    nodes.update({name : node})

def addEdge(s, t, type):
    edge = {}
    edge.update({"s" : s})
    edge.update({"t" : t})
    edge.update({"type" : type})
    edges.update({s + "_" + t : edge})


fileNameDot = sys.argv[1]+"_lat.dot"
fileNameYaml = sys.argv[1]+"_lat.yaml"
fin = open(fileNameDot, "r")
fout = open(fileNameYaml,"w")



dict = {}
nodes = {}
edges = {}


lines = fin.readlines()
for line in lines:
    isEdge = re.match("\"(.*)\" -> \"(.*)\" \[(.*)\]", line)
    if isEdge:
        addEdge(isEdge.group(1), isEdge.group(2), isEdge.group(3))
    else:
        isNode = re.match("\"(.*)\" \[(.*)\]", line)
        if isNode:
            addNode(isNode.group(1), isNode.group(2))

fout.write(yaml.safe_dump(nodes, default_flow_style=False))
fout.write(yaml.safe_dump(edges, default_flow_style=False))        

fin.close()
fout.close()