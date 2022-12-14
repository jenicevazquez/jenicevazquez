/****** Object:  Table [dbo].[archivos]    Script Date: 19/09/2019 01:38:24 p. m. ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
SET ANSI_PADDING ON
GO
CREATE TABLE [dbo].[archivos](
	[id] [int] IDENTITY(1,1) NOT NULL,
	[archivos] [varchar](1000) NULL,
	[created_by] [int] NULL,
	[hash] [varchar](1000) NULL,
	[ruta] [varchar](1000) NULL CONSTRAINT [DF_archivos_folder_1]  DEFAULT ('Exp. Operaciones'),
	[created_at] [datetime] NULL,
	[updated_at] [datetime] NULL,
	[filesize] [int] NULL,
	[procesando] [int] NOT NULL CONSTRAINT [DF_archivos_procesando]  DEFAULT ((0)),
	[captura] [varchar](50) NULL,
	[licencia] [int] NULL,
 CONSTRAINT [PK_archivos] PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
SET ANSI_PADDING OFF
GO
